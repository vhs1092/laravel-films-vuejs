<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmsGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('film_genres')->truncate();

        $types = [
            [
                'id' => 1,
                'film_id' => 1,
                'genre_id' => 1,
            ],
            [
                'id' => 2,
                'film_id' => 1,
                'genre_id' => 3,
            ],
            [
                'id' => 3,
                'film_id' => 1,
                'genre_id' => 2,
            ],
            [
                'id' => 4,
                'film_id' => 2,
                'genre_id' => 2,
            ],
            [
                'id' => 5,
                'film_id' => 2,
                'genre_id' => 3,
            ],
            [
                'id' => 6,
                'film_id' => 2,
                'genre_id' => 1,
            ],
            [
                'id' => 7,
                'film_id' => 3,
                'genre_id' => 3,
            ],
        ];

        DB::table('film_genres')->insert($types);

    }
}
