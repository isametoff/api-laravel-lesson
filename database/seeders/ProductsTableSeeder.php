<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::factory()
            ->count(15000)
            ->create();
    }
}