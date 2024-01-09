<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected  $table = 'orders';

    protected $guarded = [];

    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class, 'id_status_pembayaran', 'id_status_pembayaran');
    }

    public function film()
    {
        return $this->belongsTo(Film::class, 'id_film', 'id_film');
    }
}



