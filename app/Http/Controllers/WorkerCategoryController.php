<?php

namespace App\Http\Controllers;

use App\Models\WorkerCategory;
use Illuminate\Http\Request;

class WorkerCategoryController extends Controller
{
    public function index()
    {
        $categories = WorkerCategory::withCount('workers')
            ->orderBy('name')
            ->paginate(15);

        return view('worker-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('worker-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:worker_categories',
            'description' => 'nullable|string',
        ]);

        WorkerCategory::create($validated);

        return redirect()->route('worker-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(WorkerCategory $workerCategory)
    {
        return view('worker-categories.edit', compact('workerCategory'));
    }

    public function update(Request $request, WorkerCategory $workerCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:worker_categories,name,' . $workerCategory->id,
            'description' => 'nullable|string',
        ]);

        $workerCategory->update($validated);

        return redirect()->route('worker-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(WorkerCategory $workerCategory)
    {
        if ($workerCategory->workers()->count() > 0) {
            return redirect()->back()->withErrors('Cannot delete category with assigned workers.');
        }

        $workerCategory->delete();

        return redirect()->route('worker-categories.index')->with('success', 'Category deleted successfully.');
    }
}
