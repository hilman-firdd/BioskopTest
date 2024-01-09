<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            1 => 'Menunggu Pembayaran',
            2 => 'Telah dibayar',
            3 => 'Dibatalkan',
        ];

        PaymentStatus::withoutEvents(function () use ($status) {
            foreach ($status as $id => $name) {
                PaymentStatus::create([
                    'id_status_pembayaran' => $id,
                    'deskripsi' => $name,
                ]);
            }
        });
    }
}
