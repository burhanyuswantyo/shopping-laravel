<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh insert 1 data
        // Category::query()
        //     ->create([
        //         'name' => 'Category 1',
        //         'description' => 'Description 1',
        //     ]);

        $categories = [
            ['name' => 'Category 1', 'description' => 'Description 1'],
            ['name' => 'Category 2', 'description' => 'Description 2'],
            ['name' => 'Category 3', 'description' => 'Description 3'],
        ];

        foreach ($categories as $category) {
            Category::query()
                ->create($category);
        }
    }
}
