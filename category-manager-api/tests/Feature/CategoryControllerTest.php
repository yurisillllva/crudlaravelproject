<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_paginated_categories()
    {
        Category::factory()->count(15)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'children', 'links']
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_creates_a_new_category()
    {
        $parent = Category::factory()->create();

        $response = $this->postJson('/api/categories', [
            'name' => 'New Category',
            'description' => 'Test Description',
            'parent_id' => $parent->id
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'New Category'])
            ->assertJsonStructure(['data' => ['children']]);

        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    /** @test */
    public function it_shows_specific_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $category->id]]);
    }

    /** @test */
    public function it_updates_a_category()
    {
        $category = Category::factory()->create();
        $parent = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Updated Name',
            'parent_id' => $parent->id
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'parent_id' => $parent->id
        ]);
    }

    /** @test */
    public function it_deletes_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted($category);
    }

    /** @test */
    public function it_prevents_self_parenting()
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'parent_id' => $category->id
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['parent_id']);
    }
}