<?php

namespace App\Http\Controllers\Api;

use App\Models\Film;
use Illuminate\Http\Request;

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
}
