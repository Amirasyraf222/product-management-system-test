<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Electronics', 'Furniture', 'Office Supplies', 'Accessories'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
