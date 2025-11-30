<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\MaterialCategory;
use App\Models\Supplier;
use App\Models\Material;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestItem;
use App\Models\WorkerCategory;
use App\Models\WorkerPosition;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@construction-erp.com',
            'password' => Hash::make('password'),
        ]);

        // Create Clients
        $clients = [
            ['name' => 'ABC Corporation', 'email' => 'contact@abc-corp.com', 'phone' => '555-0101', 'address' => '123 Business St, Metro City'],
            ['name' => 'XYZ Developers', 'email' => 'info@xyz-dev.com', 'phone' => '555-0102', 'address' => '456 Commerce Ave, Downtown'],
            ['name' => 'BuildRight Inc', 'email' => 'hello@buildright.com', 'phone' => '555-0103', 'address' => '789 Industrial Rd, Uptown'],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        // Create Projects
        $projects = [
            [
                'name' => 'Downtown Office Complex',
                'client_id' => 1,
                'description' => '15-story commercial building with modern amenities',
                'location' => '100 Main Street, Metro City',
                'start_date' => '2024-01-15',
                'end_date' => '2025-06-30',
                'budget' => 15000000.00,
                'status' => 'Active',
            ],
            [
                'name' => 'Riverside Residential Tower',
                'client_id' => 2,
                'description' => '30-floor luxury residential building',
                'location' => '250 River Road, Downtown',
                'start_date' => '2024-03-01',
                'end_date' => '2025-12-31',
                'budget' => 25000000.00,
                'status' => 'Active',
            ],
            [
                'name' => 'Industrial Warehouse Facility',
                'client_id' => 3,
                'description' => 'Large-scale warehouse with loading docks',
                'location' => '500 Logistics Lane, Uptown',
                'start_date' => '2024-02-01',
                'end_date' => '2024-11-30',
                'budget' => 8000000.00,
                'status' => 'Planning',
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        // Create Material Categories
        $categories = [
            ['name' => 'Concrete & Cement', 'description' => 'All types of concrete and cement materials'],
            ['name' => 'Steel & Rebar', 'description' => 'Structural steel and reinforcement bars'],
            ['name' => 'Lumber & Wood', 'description' => 'Timber, plywood, and wood products'],
            ['name' => 'Electrical', 'description' => 'Wiring, fixtures, and electrical components'],
            ['name' => 'Plumbing', 'description' => 'Pipes, fittings, and plumbing fixtures'],
        ];

        foreach ($categories as $categoryData) {
            MaterialCategory::create($categoryData);
        }

        // Create Suppliers
        $suppliers = [
            ['name' => 'Metro Building Supply', 'email' => 'sales@metrosupply.com', 'phone' => '555-1001', 'address' => '1000 Supply Road'],
            ['name' => 'Industrial Materials Co', 'email' => 'orders@indmat.com', 'phone' => '555-1002', 'address' => '2000 Factory Ave'],
            ['name' => 'Construction Depot', 'email' => 'info@constdepot.com', 'phone' => '555-1003', 'address' => '3000 Builder Blvd'],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }

        // Create Materials
        $materials = [
            ['sku' => 'MAT-001', 'name' => 'Portland Cement (50kg)', 'category_id' => 1, 'unit_of_measure' => 'bag', 'quantity_in_stock' => 500, 'reorder_level' => 100, 'unit_price' => 12.50],
            ['sku' => 'MAT-002', 'name' => 'Ready Mix Concrete', 'category_id' => 1, 'unit_of_measure' => 'meter', 'quantity_in_stock' => 50, 'reorder_level' => 20, 'unit_price' => 150.00],
            ['sku' => 'MAT-003', 'name' => 'Steel Rebar 12mm', 'category_id' => 2, 'unit_of_measure' => 'piece', 'quantity_in_stock' => 1000, 'reorder_level' => 200, 'unit_price' => 8.75],
            ['sku' => 'MAT-004', 'name' => 'Structural Steel Beam', 'category_id' => 2, 'unit_of_measure' => 'piece', 'quantity_in_stock' => 150, 'reorder_level' => 50, 'unit_price' => 450.00],
            ['sku' => 'MAT-005', 'name' => 'Plywood 4x8 ft', 'category_id' => 3, 'unit_of_measure' => 'sheet', 'quantity_in_stock' => 300, 'reorder_level' => 75, 'unit_price' => 35.00],
            ['sku' => 'MAT-006', 'name' => '2x4 Lumber (8ft)', 'category_id' => 3, 'unit_of_measure' => 'piece', 'quantity_in_stock' => 800, 'reorder_level' => 200, 'unit_price' => 6.50],
            ['sku' => 'MAT-007', 'name' => 'Electrical Wire 12AWG', 'category_id' => 4, 'unit_of_measure' => 'meter', 'quantity_in_stock' => 2000, 'reorder_level' => 500, 'unit_price' => 2.25],
            ['sku' => 'MAT-008', 'name' => 'PVC Pipe 2inch', 'category_id' => 5, 'unit_of_measure' => 'meter', 'quantity_in_stock' => 500, 'reorder_level' => 100, 'unit_price' => 4.50],
        ];

        foreach ($materials as $materialData) {
            Material::create($materialData);
        }

        // Create Worker Categories
        $workerCategories = [
            ['name' => 'Skilled Labor', 'description' => 'Specialized construction workers'],
            ['name' => 'General Labor', 'description' => 'General construction workers'],
            ['name' => 'Management', 'description' => 'Project and site management'],
        ];

        foreach ($workerCategories as $categoryData) {
            WorkerCategory::create($categoryData);
        }

        // Create Worker Positions
        $positions = [
            ['name' => 'Foreman', 'description' => 'Site supervisor and team leader', 'base_daily_rate' => 280.00],
            ['name' => 'Carpenter', 'description' => 'Skilled woodworker', 'base_daily_rate' => 224.00],
            ['name' => 'Electrician', 'description' => 'Licensed electrical specialist', 'base_daily_rate' => 256.00],
            ['name' => 'Plumber', 'description' => 'Licensed plumbing specialist', 'base_daily_rate' => 240.00],
            ['name' => 'Mason', 'description' => 'Bricklayer and concrete specialist', 'base_daily_rate' => 208.00],
            ['name' => 'General Laborer', 'description' => 'General construction worker', 'base_daily_rate' => 144.00],
        ];

        foreach ($positions as $positionData) {
            WorkerPosition::create($positionData);
        }

        // Create Workers
        $workers = [
            ['worker_id' => 'WKR-001', 'first_name' => 'John', 'last_name' => 'Smith', 'position_id' => 1, 'category_id' => 3, 'email' => 'john.smith@example.com', 'phone' => '555-2001', 'hire_date' => '2023-01-15', 'status' => 'Active'],
            ['worker_id' => 'WKR-002', 'first_name' => 'Maria', 'last_name' => 'Garcia', 'position_id' => 2, 'category_id' => 1, 'email' => 'maria.garcia@example.com', 'phone' => '555-2002', 'hire_date' => '2023-02-20', 'status' => 'Active'],
            ['worker_id' => 'WKR-003', 'first_name' => 'James', 'last_name' => 'Johnson', 'position_id' => 3, 'category_id' => 1, 'email' => 'james.johnson@example.com', 'phone' => '555-2003', 'hire_date' => '2023-03-10', 'status' => 'Active'],
            ['worker_id' => 'WKR-004', 'first_name' => 'Sarah', 'last_name' => 'Williams', 'position_id' => 4, 'category_id' => 1, 'email' => 'sarah.williams@example.com', 'phone' => '555-2004', 'hire_date' => '2023-04-05', 'status' => 'Active'],
            ['worker_id' => 'WKR-005', 'first_name' => 'Michael', 'last_name' => 'Brown', 'position_id' => 5, 'category_id' => 1, 'email' => 'michael.brown@example.com', 'phone' => '555-2005', 'hire_date' => '2023-05-12', 'status' => 'Active'],
            ['worker_id' => 'WKR-006', 'first_name' => 'David', 'last_name' => 'Martinez', 'position_id' => 6, 'category_id' => 2, 'email' => 'david.martinez@example.com', 'phone' => '555-2006', 'hire_date' => '2023-06-18', 'status' => 'Active'],
        ];

        foreach ($workers as $workerData) {
            Worker::create($workerData);
        }

        // Create Material Requests
        $materialRequests = [
            [
                'project_id' => 1,
                'requested_by' => 1,
                'date_needed' => '2024-06-15',
                'status' => 'Pending',
                'purpose' => 'Materials needed for foundation work',
            ],
            [
                'project_id' => 2,
                'requested_by' => 1,
                'date_needed' => '2024-06-20',
                'status' => 'Manager Approved',
                'purpose' => 'Steel beams for structural framework',
            ],
        ];

        foreach ($materialRequests as $index => $requestData) {
            $request = MaterialRequest::create($requestData);

            // Add items to each request
            if ($index === 0) {
                MaterialRequestItem::create([
                    'material_request_id' => $request->id,
                    'material_id' => 1,
                    'quantity_requested' => 100,
                    'notes' => 'For foundation work',
                ]);
                MaterialRequestItem::create([
                    'material_request_id' => $request->id,
                    'material_id' => 2,
                    'quantity_requested' => 25,
                    'notes' => 'Concrete mix for foundation',
                ]);
            } else {
                MaterialRequestItem::create([
                    'material_request_id' => $request->id,
                    'material_id' => 4,
                    'quantity_requested' => 50,
                    'notes' => 'Structural beams',
                ]);
            }
        }
    }
}
