<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
{
    // Criar 5 categorias pai com 3 filhos cada
    Category::factory()
        ->count(5)
        ->withChildren()
        ->create();
}
}
