<?php

namespace App\Http\Controllers;

use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        $categories = MaterialCategory::withCount('materials')
            ->orderBy('name')
            ->paginate(15);

        return view('material-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('material-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:material_categories',
            'description' => 'nullable|string',
        ]);

        MaterialCategory::create($validated);

        return redirect()->route('material-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(MaterialCategory $materialCategory)
    {
        return view('material-categories.edit', compact('materialCategory'));
    }

    public function update(Request $request, MaterialCategory $materialCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:material_categories,name,' . $materialCategory->id,
            'description' => 'nullable|string',
        ]);

        $materialCategory->update($validated);

        return redirect()->route('material-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(MaterialCategory $materialCategory)
    {
        if ($materialCategory->materials()->count() > 0) {
            return redirect()->back()->withErrors(['Cannot delete category with materials.']);
        }

        $materialCategory->delete();

        return redirect()->route('material-categories.index')->with('success', 'Category deleted successfully.');
    }
}
