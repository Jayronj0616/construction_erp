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
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects-search', [ProjectController::class, 'search'])->name('projects.search');

    // Materials
    Route::resource('materials', MaterialController::class);
    Route::get('materials-search', [MaterialController::class, 'search'])->name('materials.search');
    Route::get('materials/{material}/add-stock', [MaterialController::class, 'addStock'])->name('materials.add-stock');
    Route::post('materials/{material}/add-stock', [MaterialController::class, 'storeStock'])->name('materials.store-stock');
    Route::get('materials/{material}/remove-stock', [MaterialController::class, 'removeStock'])->name('materials.remove-stock');
    Route::post('materials/{material}/remove-stock', [MaterialController::class, 'destroyStock'])->name('materials.destroy-stock');
    Route::get('materials/low-stock/view', [MaterialController::class, 'lowStock'])->name('materials.low-stock');

    // Material Categories
    Route::resource('material-categories', MaterialCategoryController::class);

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    // Material Requests
    Route::resource('material-requests', MaterialRequestController::class);
    Route::get('material-requests/{materialRequest}/supervisor-approval', [MaterialRequestController::class, 'supervisorApproval'])->name('material-requests.supervisor-approval');
    Route::post('material-requests/{materialRequest}/supervisor-approval', [MaterialRequestController::class, 'supervisorApprovalStore'])->name('material-requests.supervisor-approval-store');
    Route::get('material-requests/{materialRequest}/manager-approval', [MaterialRequestController::class, 'managerApproval'])->name('material-requests.manager-approval');
    Route::post('material-requests/{materialRequest}/manager-approval', [MaterialRequestController::class, 'managerApprovalStore'])->name('material-requests.manager-approval-store');
    Route::get('material-requests/{materialRequest}/issue', [MaterialRequestController::class, 'issue'])->name('material-requests.issue');
    Route::post('material-requests/{materialRequest}/issue', [MaterialRequestController::class, 'issueStore'])->name('material-requests.issue-store');
    Route::get('material-requests/{materialRequest}/resubmit', [MaterialRequestController::class, 'resubmit'])->name('material-requests.resubmit');
    Route::post('material-requests/{materialRequest}/resubmit', [MaterialRequestController::class, 'resubmitStore'])->name('material-requests.resubmit-store');
    Route::post('material-requests/{materialRequest}/cancel', [MaterialRequestController::class, 'cancel'])->name('material-requests.cancel');

    // Workers
    Route::resource('workers', WorkerController::class);
    Route::get('workers-search', [WorkerController::class, 'search'])->name('workers.search');
    Route::get('workers/{worker}/add-skill', [WorkerController::class, 'addSkill'])->name('workers.add-skill');
    Route::post('workers/{worker}/add-skill', [WorkerController::class, 'storeSkill'])->name('workers.store-skill');
    Route::delete('workers/{worker}/skill/{skillId}', [WorkerController::class, 'removeSkill'])->name('workers.remove-skill');
    Route::get('workers/{worker}/add-emergency-contact', [WorkerController::class, 'addEmergencyContact'])->name('workers.add-emergency-contact');
    Route::post('workers/{worker}/add-emergency-contact', [WorkerController::class, 'storeEmergencyContact'])->name('workers.store-emergency-contact');
    Route::put('workers/{worker}/emergency-contact/{contactId}', [WorkerController::class, 'updateEmergencyContact'])->name('workers.update-emergency-contact');
    Route::get('workers/{worker}/assign-project', [WorkerController::class, 'assignProject'])->name('workers.assign-project');
    Route::post('workers/{worker}/assign-project', [WorkerController::class, 'storeProjectAssignment'])->name('workers.store-project-assignment');
    Route::put('workers/{worker}/assignment/{assignmentId}/complete', [WorkerController::class, 'completeAssignment'])->name('workers.complete-assignment');

    // Worker Positions
    Route::resource('worker-positions', WorkerPositionController::class);

    // Worker Categories
    Route::resource('worker-categories', WorkerCategoryController::class);
});

require __DIR__.'/auth.php';
