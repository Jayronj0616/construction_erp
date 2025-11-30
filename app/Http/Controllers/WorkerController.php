<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerPosition;
use App\Models\WorkerCategory;
use App\Models\WorkerProjectAssignment;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::with('position', 'category')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $activeCount = Worker::where('status', 'Active')->count();
        $onLeaveCount = Worker::where('status', 'On-Leave')->count();

        return view('workers.index', compact('workers', 'activeCount', 'onLeaveCount'));
    }

    public function create()
    {
        $positions = WorkerPosition::orderBy('name')->get();
        $categories = WorkerCategory::orderBy('name')->get();

        return view('workers.create', compact('positions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'worker_id' => 'required|string|unique:workers',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'position_id' => 'required|exists:worker_positions,id',
            'category_id' => 'required|exists:worker_categories,id',
            'hire_date' => 'required|date',
        ]);

        Worker::create($validated);

        return redirect()->route('workers.index')->with('success', 'Worker created successfully.');
    }

    public function show(Worker $worker)
    {
        $worker->load('position', 'category', 'emergencyContact', 'skills', 'projectAssignments.project');

        $expiringSkills = $worker->expiringCertifications();
        $expiredSkills = $worker->expiredCertifications();

        return view('workers.show', compact('worker', 'expiringSkills', 'expiredSkills'));
    }

    public function edit(Worker $worker)
    {
        $positions = WorkerPosition::orderBy('name')->get();
        $categories = WorkerCategory::orderBy('name')->get();

        return view('workers.edit', compact('worker', 'positions', 'categories'));
    }

    public function update(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'worker_id' => 'required|string|unique:workers,worker_id,' . $worker->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'position_id' => 'required|exists:worker_positions,id',
            'category_id' => 'required|exists:worker_categories,id',
            'hire_date' => 'required|date',
            'status' => 'required|in:Active,On-Leave,Transferred,Terminated',
        ]);

        $worker->update($validated);

        return redirect()->route('workers.show', $worker)->with('success', 'Worker updated successfully.');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();

        return redirect()->route('workers.index')->with('success', 'Worker deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $workers = Worker::with('position', 'category')
            ->where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('worker_id', 'like', "%$query%")
            ->orWhereHas('position', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->paginate(15);

        return view('workers.index', compact('workers'));
    }

    public function addSkill(Worker $worker)
    {
        return view('workers.add-skill', compact('worker'));
    }

    public function storeSkill(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'skill_name' => 'required|string',
            'proficiency' => 'required|in:Beginner,Intermediate,Expert',
            'certification_expiry' => 'nullable|date',
        ]);

        $worker->skills()->create($validated);

        return redirect()->route('workers.show', $worker)->with('success', 'Skill added successfully.');
    }

    public function removeSkill(Worker $worker, $skillId)
    {
        $skill = $worker->skills()->findOrFail($skillId);
        $skill->delete();

        return redirect()->route('workers.show', $worker)->with('success', 'Skill removed successfully.');
    }

    public function addEmergencyContact(Worker $worker)
    {
        return view('workers.add-emergency-contact', compact('worker'));
    }

    public function storeEmergencyContact(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'contact_name' => 'required|string',
            'relationship' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $worker->emergencyContact()->create($validated);

        return redirect()->route('workers.show', $worker)->with('success', 'Emergency contact added successfully.');
    }

    public function updateEmergencyContact(Request $request, Worker $worker, $contactId)
    {
        $contact = $worker->emergencyContact()->findOrFail($contactId);

        $validated = $request->validate([
            'contact_name' => 'required|string',
            'relationship' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $contact->update($validated);

        return redirect()->route('workers.show', $worker)->with('success', 'Emergency contact updated successfully.');
    }

    public function assignProject(Worker $worker)
    {
        $projects = Project::where('status', 'Active')->orderBy('name')->get();
        $positions = WorkerPosition::orderBy('name')->get();

        return view('workers.assign-project', compact('worker', 'projects', 'positions'));
    }

    public function storeProjectAssignment(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'assignment_role' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['worker_id'] = $worker->id;
        $validated['status'] = 'Active';

        WorkerProjectAssignment::create($validated);

        return redirect()->route('workers.show', $worker)->with('success', 'Worker assigned to project successfully.');
    }

    public function completeAssignment(Worker $worker, $assignmentId)
    {
        $assignment = $worker->projectAssignments()->findOrFail($assignmentId);
        $assignment->update([
            'status' => 'Completed',
            'end_date' => now()->toDateString(),
        ]);

        return redirect()->route('workers.show', $worker)->with('success', 'Assignment completed.');
    }
}
