<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $film = new \App\Models\Film();
            $film->nama_film = $faker->name;
            $film->harga_tiket = $faker->numberBetween(10000, 50000);
            $film->jam_tayang = $faker->dateTimeBetween('-1 day', '+1 week');
            $film->film_image = "https://picsum.photos/id/". $faker->numberBetween(1, 600)."/200/300";
            $film->save();
        }
    }
}
