<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                ['name' => 'Books','created_at' => date("Y-m-d H:i:s") ],
                ['name' => 'Electronics','created_at' => date("Y-m-d H:i:s") ],
                ['name' => 'FashionMen','created_at' => date("Y-m-d H:i:s") ],
                ['name' => 'KindleStore','created_at' => date("Y-m-d H:i:s") ],
                ['name' => 'Movies','created_at' => date("Y-m-d H:i:s") ],
                ['name' => 'VideoGames','created_at' => date("Y-m-d H:i:s") ],
            ]);
    }
}
