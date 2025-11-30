<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkerPositionController;
use App\Http\Controllers\WorkerCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes - Demo Mode (Read Only)
|--------------------------------------------------------------------------
*/

// Redirect to dashboard for demo
Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard - No auth required for demo
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// All routes accessible without authentication (GET only for demo)
// Projects
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::get('projects-search', [ProjectController::class, 'search'])->name('projects.search');

// Materials
Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('materials/create', [MaterialController::class, 'create'])->name('materials.create');
Route::get('materials-search', [MaterialController::class, 'search'])->name('materials.search');
Route::get('materials/low-stock/view', [MaterialController::class, 'lowStock'])->name('materials.low-stock');
Route::get('materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
Route::get('materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
Route::get('materials/{material}/add-stock', [MaterialController::class, 'addStock'])->name('materials.add-stock');
Route::get('materials/{material}/remove-stock', [MaterialController::class, 'removeStock'])->name('materials.remove-stock');

// Material Categories
Route::get('material-categories', [MaterialCategoryController::class, 'index'])->name('material-categories.index');
Route::get('material-categories/create', [MaterialCategoryController::class, 'create'])->name('material-categories.create');
Route::get('material-categories/{material_category}', [MaterialCategoryController::class, 'show'])->name('material-categories.show');
Route::get('material-categories/{material_category}/edit', [MaterialCategoryController::class, 'edit'])->name('material-categories.edit');

// Suppliers
Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');

// Material Requests
Route::get('material-requests', [MaterialRequestController::class, 'index'])->name('material-requests.index');
Route::get('material-requests/create', [MaterialRequestController::class, 'create'])->name('material-requests.create');
Route::get('material-requests/{material_request}', [MaterialRequestController::class, 'show'])->name('material-requests.show');
Route::get('material-requests/{material_request}/edit', [MaterialRequestController::class, 'edit'])->name('material-requests.edit');
Route::get('material-requests/{materialRequest}/supervisor-approval', [MaterialRequestController::class, 'supervisorApproval'])->name('material-requests.supervisor-approval');
Route::get('material-requests/{materialRequest}/manager-approval', [MaterialRequestController::class, 'managerApproval'])->name('material-requests.manager-approval');
Route::get('material-requests/{materialRequest}/issue', [MaterialRequestController::class, 'issue'])->name('material-requests.issue');
Route::get('material-requests/{materialRequest}/resubmit', [MaterialRequestController::class, 'resubmit'])->name('material-requests.resubmit');

// Workers
Route::get('workers', [WorkerController::class, 'index'])->name('workers.index');
Route::get('workers/create', [WorkerController::class, 'create'])->name('workers.create');
Route::get('workers-search', [WorkerController::class, 'search'])->name('workers.search');
Route::get('workers/{worker}', [WorkerController::class, 'show'])->name('workers.show');
Route::get('workers/{worker}/edit', [WorkerController::class, 'edit'])->name('workers.edit');
Route::get('workers/{worker}/add-skill', [WorkerController::class, 'addSkill'])->name('workers.add-skill');
Route::get('workers/{worker}/add-emergency-contact', [WorkerController::class, 'addEmergencyContact'])->name('workers.add-emergency-contact');
Route::get('workers/{worker}/assign-project', [WorkerController::class, 'assignProject'])->name('workers.assign-project');

// Worker Positions
Route::get('worker-positions', [WorkerPositionController::class, 'index'])->name('worker-positions.index');
Route::get('worker-positions/create', [WorkerPositionController::class, 'create'])->name('worker-positions.create');
Route::get('worker-positions/{worker_position}', [WorkerPositionController::class, 'show'])->name('worker-positions.show');
Route::get('worker-positions/{worker_position}/edit', [WorkerPositionController::class, 'edit'])->name('worker-positions.edit');

// Worker Categories
Route::get('worker-categories', [WorkerCategoryController::class, 'index'])->name('worker-categories.index');
Route::get('worker-categories/create', [WorkerCategoryController::class, 'create'])->name('worker-categories.create');
Route::get('worker-categories/{worker_category}', [WorkerCategoryController::class, 'show'])->name('worker-categories.show');
Route::get('worker-categories/{worker_category}/edit', [WorkerCategoryController::class, 'edit'])->name('worker-categories.edit');

// Disable POST/PUT/DELETE routes - they'll return 404 in demo mode
// No auth routes needed for demo
