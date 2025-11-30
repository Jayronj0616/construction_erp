<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\MaterialRequestApproval;
use App\Models\MaterialIssuance;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\Request;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $requests = MaterialRequest::with('project', 'requester', 'items.material')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('material-requests.index', compact('requests'));
    }

    public function create()
    {
        $projects = Project::where('status', 'Active')->orderBy('name')->get();
        $materials = Material::with('category')->orderBy('name')->get();

        return view('material-requests.create', compact('projects', 'materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'date_needed' => 'required|date|after:today',
            'purpose' => 'nullable|string',
            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
            'materials.*.notes' => 'nullable|string',
        ]);

        $materialRequest = MaterialRequest::create([
            'project_id' => $validated['project_id'],
            'requested_by' => auth()->id(),
            'date_needed' => $validated['date_needed'],
            'purpose' => $validated['purpose'],
            'status' => 'Pending',
        ]);

        foreach ($validated['materials'] as $item) {
            $materialRequest->items()->create([
                'material_id' => $item['material_id'],
                'quantity_requested' => $item['quantity'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        return redirect()->route('material-requests.show', $materialRequest)->with('success', 'Material request created successfully.');
    }

    public function show(MaterialRequest $materialRequest)
    {
        $materialRequest->load('project', 'requester', 'items.material', 'approvals.approver', 'issuance');

        return view('material-requests.show', compact('materialRequest'));
    }

    public function supervisorApproval(MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canBeSupervisorApproved()) {
            return redirect()->back()->withErrors('Request cannot be approved at this stage.');
        }

        return view('material-requests.supervisor-approval', compact('materialRequest'));
    }

    public function supervisorApprovalStore(Request $request, MaterialRequest $materialRequest)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approved,rejected',
            'reason' => 'required_if:decision,rejected|nullable|string',
        ]);

        if ($validated['decision'] === 'rejected') {
            $materialRequest->update([
                'status' => 'Rejected',
                'rejection_reason' => $validated['reason'],
            ]);
        } else {
            $materialRequest->update(['status' => 'Supervisor Approved']);
        }

        $materialRequest->approvals()->create([
            'approved_by' => auth()->id(),
            'approval_level' => 'supervisor',
            'decision' => $validated['decision'],
            'reason' => $validated['reason'] ?? null,
            'decided_at' => now(),
        ]);

        $msg = $validated['decision'] === 'approved' ? 'Request approved by supervisor.' : 'Request rejected by supervisor.';
        return redirect()->route('material-requests.show', $materialRequest)->with('success', $msg);
    }

    public function managerApproval(MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canBeManagerApproved()) {
            return redirect()->back()->withErrors('Request cannot be approved at this stage.');
        }

        $materialRequest->load('items.material');
        return view('material-requests.manager-approval', compact('materialRequest'));
    }

    public function managerApprovalStore(Request $request, MaterialRequest $materialRequest)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approved,rejected',
            'reason' => 'required_if:decision,rejected|nullable|string',
        ]);

        if ($validated['decision'] === 'rejected') {
            $materialRequest->update([
                'status' => 'Rejected',
                'rejection_reason' => $validated['reason'],
            ]);
        } else {
            $materialRequest->update(['status' => 'Manager Approved']);
        }

        $materialRequest->approvals()->create([
            'approved_by' => auth()->id(),
            'approval_level' => 'manager',
            'decision' => $validated['decision'],
            'reason' => $validated['reason'] ?? null,
            'decided_at' => now(),
        ]);

        $msg = $validated['decision'] === 'approved' ? 'Request approved by manager.' : 'Request rejected by manager.';
        return redirect()->route('material-requests.show', $materialRequest)->with('success', $msg);
    }

    public function issue(MaterialRequest $materialRequest)
    {
        if (!$materialRequest->canBeIssued()) {
            return redirect()->back()->withErrors('Request is not approved yet.');
        }

        $materialRequest->load('items.material');
        return view('material-requests.issue', compact('materialRequest'));
    }

    public function issueStore(Request $request, MaterialRequest $materialRequest)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:material_request_items,id',
            'items.*.quantity_to_issue' => 'required|integer|min:0',
            'received_by' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        foreach ($validated['items'] as $itemData) {
            $item = MaterialRequestItem::find($itemData['item_id']);
            $qtyToIssue = $itemData['quantity_to_issue'];

            if ($qtyToIssue > 0) {
                // Check if sufficient stock
                if ($item->material->quantity_in_stock < $qtyToIssue) {
                    return redirect()->back()->withErrors("Insufficient stock for {$item->material->name}.");
                }

                // Deduct from inventory
                $item->material->decrement('quantity_in_stock', $qtyToIssue);

                // Update request item
                $item->increment('quantity_issued', $qtyToIssue);

                // Log transaction
                $item->material->transactions()->create([
                    'type' => 'usage',
                    'quantity' => $qtyToIssue,
                    'reference_type' => 'material_request',
                    'reference_id' => $materialRequest->id,
                    'notes' => "Issued for Project: {$materialRequest->project->name}",
                    'recorded_by' => auth()->id(),
                ]);
            }
        }

        // Update request status
        if ($materialRequest->isFullyIssued()) {
            $materialRequest->update(['status' => 'Issued']);
        } else {
            $materialRequest->update(['status' => 'Partially Issued']);
        }

        // Create issuance record
        MaterialIssuance::create([
            'material_request_id' => $materialRequest->id,
            'issued_by' => auth()->id(),
            'received_by' => $validated['received_by'],
            'issued_at' => now(),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('material-requests.show', $materialRequest)->with('success', 'Materials issued successfully.');
    }

    public function resubmit(MaterialRequest $materialRequest)
    {
        if ($materialRequest->status !== 'Rejected') {
            return redirect()->back()->withErrors('Only rejected requests can be resubmitted.');
        }

        $materialRequest->load('items.material');
        return view('material-requests.resubmit', compact('materialRequest'));
    }

    public function resubmitStore(Request $request, MaterialRequest $materialRequest)
    {
        $validated = $request->validate([
            'reason' => 'required|string',
            'materials' => 'required|array',
            'materials.*.item_id' => 'required|exists:material_request_items,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['materials'] as $item) {
            $requestItem = MaterialRequestItem::find($item['item_id']);
            $requestItem->update(['quantity_requested' => $item['quantity']]);
        }

        $materialRequest->update([
            'status' => 'Pending',
            'rejection_reason' => null,
        ]);

        return redirect()->route('material-requests.show', $materialRequest)->with('success', 'Request resubmitted successfully.');
    }

    public function cancel(MaterialRequest $materialRequest)
    {
        if (in_array($materialRequest->status, ['Issued', 'Partially Issued'])) {
            return redirect()->back()->withErrors('Cannot cancel an issued request.');
        }

        $materialRequest->update(['status' => 'Cancelled']);

        return redirect()->route('material-requests.index')->with('success', 'Request cancelled.');
    }
}
