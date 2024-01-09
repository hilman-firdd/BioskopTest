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
        for ($i = 0; $i < 10; $i++) {
            $film = new \App\Models\Film();
            $film->nama_film = $faker->name;
            $film->harga_tiket = $faker->numberBetween(10000, 50000);
            $film->jam_tayang = $faker->dateTimeBetween('-1 week', '+2 week');
            $film->film_image = $faker->imageUrl(400, 600, 'animals', true);
            $film->save();
        }
    }
}
