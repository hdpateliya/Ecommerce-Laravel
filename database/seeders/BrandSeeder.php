<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $category = ['Mi', 'Apple', 'OnePlus', 'Samsung', 'LG', 'HP', 'Lenovo', 'Dell'];
        foreach ($category as $data) {
            DB::table('brands')->insert([
                'name' => $data,
            ]);
        }
    }
}
