<?php

namespace App\Http\Controllers\Api;

use App\Models\Film;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{
    public function loadFilm(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'search' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $film = Film::select('id_film', 'nama_film', 'harga_tiket', 'jam_tayang', 'film_image')
            ->where('jam_tayang', '>=', now())
            ->where('jam_tayang', '<', now()->addDays(7))
            ->when($req->search, function ($query, $search) {
                return $query->where('nama_film', 'like', "%{$search}%");
            })
            ->orderBy('jam_tayang', 'asc')->get();

        $film->map(function ($item) {
            $item->jam_tayang = date('d M Y H:i', strtotime($item->jam_tayang));
            return $item;
        });

        return $this->sendResponse($film);
    }

    public function detailFilm(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_film' => 'required|exists:films,id_film',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $film = Film::Where('id_film', $req->id_film)->first();
        if (!$film) {
            return $this->sendError('Film tidak ditemukan', 404);
        }

        $order = Order::select('nomor_duduk')->where('id_film', $req->id_film)->whereIn('id_status_pembayaran', [1, 2])->get();
        $nomorDuduk = [];
        foreach ($order as $item) {
            $nomorDuduk = array_merge($nomorDuduk, explode(',', $item->nomor_duduk));
        }
        $nomorDuduk = array_map('trim', $nomorDuduk);

        $data = [
            'id_film' => $film->id_film,
            'nama_film' => $film->nama_film,
            'harga_tiket' => $film->harga_tiket,
            'tgl_tayang' => date('d M Y', strtotime($film->jam_tayang)),
            'jam_tayang' => date('H:i', strtotime($film->jam_tayang)),
            'film_image' => $film->film_image,
            'nomor_duduk' => $nomorDuduk,
        ];

        return $this->sendResponse($data);
    }

    public function createOrder(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_film' => 'required|exists:films,id_film',
            'id_status_pembayaran' => 'required|int|in:1',
            'nomor_duduk' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $film = Film::Where('id_film', $req->id_film)->where('jam_tayang', '>=', now())->first();
        if (!$film) {
            return $this->sendError('Film tidak ditemukan', 404);
        }

        $nomorKursi = explode(',', $req->nomor_duduk);
        $nomorKursi = array_map('trim', $nomorKursi);

        foreach ($nomorKursi as $nomor) {
            $cek = Order::where('nomor_duduk', 'like', "%{$nomor}%")
                ->where('id_film', $req->id_film)
                ->whereIn('id_status_pembayaran', [1, 2])
                ->first();
            if ($cek) {
                return $this->sendError('Nomor duduk ' . $nomor . ' sudah dipesan', 400);
            }
        }

        $data = [];
        $order = new Order();
        try {
            DB::beginTransaction();
            $order->id_film = $req->id_film;
            $order->id_status_pembayaran = $req->id_status_pembayaran;
            $order->nomor_duduk = $req->nomor_duduk;
            $order->user_id = auth()->user()->id;
            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError("Terjadi Kesalahan Server", 500);
        }

        $data = [
            'order_id' => $order->id,
            'nama_film' => $order->film->nama_film,
        ];

        return $this->sendResponse($data);
    }

    public function updateOrder(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_order' => 'required|exists:orders,id_order',
            'status_pembayaran' => 'required|int|in:2,3',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }

        $cek = Order::where('id_order', $req->id_order)->first();
        
        if ($cek->user_id != auth()->user()->id) {
            return $this->sendError('Order tidak ditemukan', 404);
        }
        
        if ($cek->id_status_pembayaran == 2) {
            return $this->sendError('Order sudah dibayar', 400);
        }

        if ($cek->id_status_pembayaran == 3) {
            return $this->sendError('Order sudah dibatalkan', 400);
        }

        try {
            DB::beginTransaction();
            Order::where('id_order', $req->id_order)->update([
                'id_status_pembayaran' => $req->status_pembayaran,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError("Terjadi Kesalahan Server", 500);
        }
        $order = Order::where('id_order', $req->id_order)->first();
        $data = [
            'order_id' => $order->id_order,
            'status_pembayaran' => $order->payment_status->deskripsi,
        ];

        return $this->sendResponse($data);
    }

    public function listOrder()
    {
        $idUser = auth()->user()->id;
        $orderUnpaid = Order::join('films', 'orders.id_film', '=', 'films.id_film')
            ->select('orders.*', 'films.*')
            ->where('id_status_pembayaran', '=', 1)
            ->where('user_id', '=', $idUser)
            ->orderBy('orders.created_at', 'desc')->get();

        
        if (!$orderUnpaid->isEmpty()) {
            $orderUnpaid->map(function ($item) {
                $item->jam_tayang = date('d M Y H:i', strtotime($item->jam_tayang));
                return $item;
            });
        }

        $orderPaid = Order::join('films', 'orders.id_film', '=', 'films.id_film')
            ->select('orders.*', 'films.*')
            ->where('id_status_pembayaran', '=', 2)
            ->where('user_id', '=', $idUser)
            ->where('jam_tayang', '>=', now())
            ->orderBy('orders.created_at', 'desc')->get();

        if (!$orderPaid->isEmpty()) {
            $orderPaid->map(function ($item) {
                $item->jam_tayang = date('d M Y H:i', strtotime($item->jam_tayang));
                return $item;
            });
        }

        $order = [
            'unpaid' => $orderUnpaid,
            'paid' => $orderPaid,
        ];

        return $this->sendResponse($order);
    }
}
