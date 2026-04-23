<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::updateOrCreate(
            ['name' => 'Sense categoria'],
            ['color' => '#64748b', 'icon' => 'help_outline', 'active' => true]
        );
    }
}
