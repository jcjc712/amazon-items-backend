<?php

use Illuminate\Database\Seeder;

class SortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sorts')->insert([
            ['name' => 'salesrank','created_at' => date("Y-m-d H:i:s") ],
            ['name' => 'price','created_at' => date("Y-m-d H:i:s") ],
            ['name' => '-price','created_at' => date("Y-m-d H:i:s") ],
            ['name' => 'titlerank','created_at' => date("Y-m-d H:i:s") ],
        ]);
    }
}
