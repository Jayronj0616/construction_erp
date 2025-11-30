@include('materials.partials.form', [
    'action' => route('materials.store'),
    'method' => null,
    'material' => new \App\Models\Material(),
    'categories' => $categories,
    'suppliers' => $suppliers,
    'selectedSuppliers' => []
])
