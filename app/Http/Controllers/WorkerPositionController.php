<?php

namespace App\Http\Controllers;

use App\Models\WorkerPosition;
use Illuminate\Http\Request;

class WorkerPositionController extends Controller
{
    public function index()
    {
        $positions = WorkerPosition::withCount('workers')
            ->orderBy('name')
            ->paginate(15);

        return view('worker-positions.index', compact('positions'));
    }

    public function create()
    {
        return view('worker-positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:worker_positions',
            'description' => 'nullable|string',
            'base_daily_rate' => 'required|numeric|min:0',
        ]);

        WorkerPosition::create($validated);

        return redirect()->route('worker-positions.index')->with('success', 'Position created successfully.');
    }

    public function edit(WorkerPosition $workerPosition)
    {
        return view('worker-positions.edit', compact('workerPosition'));
    }

    public function update(Request $request, WorkerPosition $workerPosition)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:worker_positions,name,' . $workerPosition->id,
            'description' => 'nullable|string',
            'base_daily_rate' => 'required|numeric|min:0',
        ]);

        $workerPosition->update($validated);

        return redirect()->route('worker-positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy(WorkerPosition $workerPosition)
    {
        if ($workerPosition->workers()->count() > 0) {
            return redirect()->back()->withErrors('Cannot delete position with assigned workers.');
        }

        $workerPosition->delete();

        return redirect()->route('worker-positions.index')->with('success', 'Position deleted successfully.');
    }
}
