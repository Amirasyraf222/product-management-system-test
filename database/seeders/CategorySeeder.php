<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Mobile Phones & Gadgets', 'Computers & Tech', 'Beauty & Personal Care', 'Furniture & Home Living'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
