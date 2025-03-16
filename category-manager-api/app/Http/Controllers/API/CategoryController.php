<?php

namespace App\Http\Controllers\API;  // Namespace correto

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id'
    ]);

    $category = Category::create($validated);
    
    return (new CategoryResource($category->load('children')))
        ->response()
        ->setStatusCode(201);
}

    public function show($id)
{
    $category = Category::with('children')->find($id);
    
    if (!$category) {
        return response()->json([
            'error' => 'Categoria não encontrada'
        ], 404); 
    }
    
    return new CategoryResource($category);
}

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if ($validated['parent_id'] == $category->id) {
            abort(422, 'Uma categoria não pode ser pai de si mesma');
        }

        $category->update($validated);
        return new CategoryResource($category->load('children', 'parent'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}