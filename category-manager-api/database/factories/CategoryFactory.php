<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'parent_id' => null
        ];
    }

    public function withChildren()
    {
        return $this->afterCreating(function (Category $category) {
            Category::factory()
                ->count(3)
                ->create(['parent_id' => $category->id]);
        });
    }

    // public function withParent()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'parent_id' => Category::factory()
    //         ];
    //     });
    // }
}
