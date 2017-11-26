<?php

use Illuminate\Database\Seeder;

class SearchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('searches')->insert([
            ['name' => 'Title','created_at' => date("Y-m-d H:i:s") ],
            ['name' => 'MinimumPrice','created_at' => date("Y-m-d H:i:s") ],
            ['name' => 'MaximumPrice','created_at' => date("Y-m-d H:i:s") ],
        ]);
    }
}
