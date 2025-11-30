@include('materials.partials.form', [
    'action' => route('materials.update', $material),
    'method' => 'PUT',
    'material' => $material,
    'categories' => $categories,
    'suppliers' => $suppliers,
    'selectedSuppliers' => $material->suppliers->pluck('supplier_id')->toArray()
])
