<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category', 'suppliers')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $lowStockCount = Material::whereRaw('quantity_in_stock <= reorder_level')->count();

        return view('materials.index', compact('materials', 'lowStockCount'));
    }

    public function create()
    {
        $categories = MaterialCategory::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        // If AJAX request, return modal view
        if (request()->wantsJson() || request()->ajax()) {
            return view('materials.modals.create', compact('categories', 'suppliers'));
        }

        return view('materials.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:materials',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:material_categories,id',
            'unit_of_measure' => 'required|in:bag,piece,kg,meter,liter,box,bundle,roll,sheet,gallon',
            'quantity_in_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        $material = Material::create($validated);

        // Attach suppliers if provided
        if ($request->has('suppliers')) {
            foreach ($request->input('suppliers') as $supplierId) {
                $material->suppliers()->create([
                    'supplier_id' => $supplierId,
                    'supplier_price' => $validated['unit_price'],
                    'lead_time_days' => 7,
                    'is_preferred' => false,
                ]);
            }
        }

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Material created successfully!',
                'data' => $material
            ]);
        }

        return redirect()->route('materials.show', $material)->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        $material->load('category', 'suppliers.supplier', 'transactions.recordedBy');

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $categories = MaterialCategory::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $selectedSuppliers = $material->suppliers->pluck('supplier_id')->toArray();

        // If AJAX request, return modal view
        if (request()->wantsJson() || request()->ajax()) {
            return view('materials.modals.edit', compact('material', 'categories', 'suppliers', 'selectedSuppliers'));
        }

        return view('materials.edit', compact('material', 'categories', 'suppliers', 'selectedSuppliers'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:materials,sku,' . $material->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:material_categories,id',
            'unit_of_measure' => 'required|in:bag,piece,kg,meter,liter,box,bundle,roll,sheet,gallon',
            'quantity_in_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        $material->update($validated);

        // Update suppliers
        $material->suppliers()->delete();
        if ($request->has('suppliers')) {
            foreach ($request->input('suppliers') as $supplierId) {
                $material->suppliers()->create([
                    'supplier_id' => $supplierId,
                    'supplier_price' => $validated['unit_price'],
                    'lead_time_days' => 7,
                    'is_preferred' => false,
                ]);
            }
        }

        // If AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Material updated successfully!',
                'data' => $material
            ]);
        }

        return redirect()->route('materials.show', $material)->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $materials = Material::with('category')
            ->where('name', 'like', "%$query%")
            ->orWhere('sku', 'like', "%$query%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->paginate(15);

        return view('materials.index', compact('materials'));
    }

    public function addStock(Material $material)
    {
        return view('materials.add-stock', compact('material'));
    }

    public function storeStock(Request $request, Material $material)
{
    // Validate input
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'notes' => 'nullable|string',
    ]);

    // Increment the material stock
    $material->increment('quantity_in_stock', $validated['quantity']);

    // Record the stock transaction
    $material->transactions()->create([
        'type' => 'addition',
        'quantity' => $validated['quantity'],
        'notes' => $validated['notes'] ?? 'Stock added',
        'recorded_by' => auth()->id() ?: null, // <-- Use null if no user
    ]);

    return redirect()
        ->route('materials.show', $material)
        ->with('success', 'Stock added successfully.');
}


    public function removeStock(Material $material)
    {
        return view('materials.remove-stock', compact('material'));
    }

    public function destroyStock(Request $request, Material $material)
{
    // Validate input
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
        'type' => 'required|in:usage,adjustment,damage,return',
        'notes' => 'nullable|string',
    ]);

    // Check if there is enough stock
    if ($material->quantity_in_stock < $validated['quantity']) {
        return redirect()->back()->withErrors([
            'quantity' => 'Insufficient stock.'
        ]);
    }

    // Decrement the material stock
    $material->decrement('quantity_in_stock', $validated['quantity']);

    // Record the transaction
    $material->transactions()->create([
        'type' => $validated['type'],
        'quantity' => $validated['quantity'],
        'notes' => $validated['notes'] ?? ucfirst($validated['type']), // default note
        'recorded_by' => auth()->id() ?: null, // make nullable to avoid FK issues
    ]);

    return redirect()
        ->route('materials.show', $material)
        ->with('success', 'Stock removed successfully.');
}


    public function lowStock()
    {
        $materials = Material::with('category')
            ->whereRaw('quantity_in_stock <= reorder_level')
            ->paginate(15);

        return view('materials.low-stock', compact('materials'));
    }
}
