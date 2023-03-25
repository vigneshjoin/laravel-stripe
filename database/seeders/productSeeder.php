<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['name' => 'Yellow T-Shirt','price' => '100.00','description' => 't-shit description','status' => 1],
            ['name' => 'Blue T-Shirt','price' => '200.00','description' => 't-shit description','status' => 1],
            ['name' => ' Red T-Shirt','price' => '150.00','description' => 't-shit description','status' => 1],
            ['name' => 'Men T-Shirt','price' => '900.00','description' => 't-shit description','status' => 1],
            ['name' => 'Black T-Shirt','price' => '500.00','description' => 't-shit description','status' => 1],
        ];

        DB::table('products')->insert($products);
    }
}
