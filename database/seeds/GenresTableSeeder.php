<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id' => 1,
                'uuid' => Uuid::generate(4)->string,
                'name' => 'horror',
                'status' => 1,
            ],
            [
                'id' => 2,
                'uuid' => Uuid::generate(4)->string,
                'name' => 'action',
                'status' => 1,
            ],
            [
                'id' => 3,
                'uuid' => Uuid::generate(4)->string,
                'name' => 'drama',
                'status' => 1,
            ]
        ];

        DB::table('genres')->insert($types);

    }
}
