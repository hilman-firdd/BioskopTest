<?php

namespace App\Http\Controllers\Api;

use App\Models\Film;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{
    public function loadFilm()
    {
        $film = Film::select('id_film', 'nama_film', 'harga_tiket', 'jam_tayang', 'film_image')
            ->where('jam_tayang', '>', now())
            ->orderBy('jam_tayang', 'asc')->get();

        $film->map(function ($item) {
            $item->jam_tayang = date('d M Y H:i', strtotime($item->jam_tayang));
            return $item;
        });

        return $this->sendResponse($film);
    }

    public function createOrder(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_film' => 'required|exists:films,id_film',
            'id_status_pembayaran' => 'required|int|in:1',
            'nomor_duduk' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $film = Film::Where('id_film', $req->id_film)->first();
        if (!$film) {
            return $this->sendError('Film tidak ditemukan');
        }

        $nomorKursi = explode(',', $req->nomor_duduk);
        $nomorKursi = array_map('trim', $nomorKursi);
        
        foreach ($nomorKursi as $nomor) {
            $cek = Order::where('nomor_duduk', 'like', "%{$nomor}%")
                ->where('id_film', $req->id_film)
                ->first();
            if ($cek) {
                return $this->sendError('Nomor duduk ' . $nomor . ' sudah dipesan');
            }
        }

        $data = [];
        $order = new Order();
        try {
            DB::beginTransaction();
            $order->id_film = $req->id_film;
            $order->id_status_pembayaran = $req->id_status_pembayaran;
            $order->nomor_duduk = $req->nomor_duduk;

            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage());
        }
        
        $data = [
            'order_id' => $order->id,
            'nama_film' => $order->film->nama_film,
        ];

        return $this->sendResponse($data);
    }
}
