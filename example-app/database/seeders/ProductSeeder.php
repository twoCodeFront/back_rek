<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Example A', 'slug' => 'First sample', 'price' => 9.99, 'vat_id' => 1],
            ['name' => 'Example B', 'slug' => 'Second sample', 'price' => 19.99, 'vat_id' => 1],
            ['name' => 'Example C', 'slug' => null, 'price' => 0.00, 'vat_id' => 2],
        ]);
    }
}
