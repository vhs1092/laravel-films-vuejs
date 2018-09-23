<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon as Carbon;


class FilmsTableSeeder extends Seeder
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
                'name' => 'X-men',
                'slug' => 'x-men',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim. Aenean dapibus enim et felis rhoncus blandit. Praesent venenatis tortor nec iaculis aliquet.',
                'release_date' => '2016-11-10',
                'rating' => 4,
                'ticket_price' => 12,
                'country' => 'United States',
                'photo' => '1537689072_5ba745f046dba.jpeg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => Uuid::generate(4)->string,
                'name' => 'Avengers',
                'slug' => 'avengers',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim. Aenean dapibus enim et felis rhoncus blandit. Praesent venenatis tortor nec iaculis aliquet.',
                'release_date' => '2017-11-17',
                'rating' => 5,
                'ticket_price' => 50,
                'country' => 'United Kingdom',
                'photo' => '1537689028_5ba745c42c213.jpeg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => Uuid::generate(4)->string,
                'name' => 'Transformers',
                'slug' => 'transformers',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim. Aenean dapibus enim et felis rhoncus blandit. Praesent venenatis tortor nec iaculis aliquet.',
                'release_date' => '2018-09-17',
                'rating' => 4,
                'ticket_price' => 20,
                'country' => 'United States',
                'photo' => '1537689111_5ba7461766dc7.jpeg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('films')->insert($types);

    }
}
