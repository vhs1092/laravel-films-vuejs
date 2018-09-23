<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();

        $types = [
            [
                'id' => 1,
                'name' => 'Victor Samayoa',
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim',
                'film_id' => 1,
                'user_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Ivette Juarez',
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim',
                'film_id' => 2,
                'user_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Codeline',
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac nisi in odio semper euismod non in metus. Sed id porttitor purus. Duis tincidunt magna sit amet quam consequat, ut mollis lectus dignissim',
                'film_id' => 3,
                'user_id' => 1,
            ],
        ];

        DB::table('comments')->insert($types);

    }
}
