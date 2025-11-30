<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            MaterialCategory::create(['name' => 'Cement & Concrete', 'description' => 'Portland cement and concrete materials']),
            MaterialCategory::create(['name' => 'Steel & Rebar', 'description' => 'Steel bars and reinforcement materials']),
            MaterialCategory::create(['name' => 'Aggregates', 'description' => 'Sand, gravel, and rock materials']),
            MaterialCategory::create(['name' => 'Bricks & Blocks', 'description' => 'Hollow blocks, bricks, and masonry units']),
            MaterialCategory::create(['name' => 'Paint & Finishing', 'description' => 'Paints, varnish, and finishing materials']),
            MaterialCategory::create(['name' => 'Electrical', 'description' => 'Electrical wires, cables, and fixtures']),
        ];

        // Create suppliers
        $suppliers = [
            Supplier::create(['name' => 'BuildRight Supplies', 'email' => 'info@buildright.com', 'phone' => '555-0001', 'city' => 'Manila']),
            Supplier::create(['name' => 'Premier Materials Co.', 'email' => 'orders@premier.com', 'phone' => '555-0002', 'city' => 'Quezon City']),
            Supplier::create(['name' => 'Industrial Steel Corp', 'email' => 'sales@industeel.com', 'phone' => '555-0003', 'city' => 'Manila']),
        ];

        // Create materials
        $materials = [
            Material::create([
                'sku' => 'CEMENT-001',
                'name' => 'Portland Cement (40kg)',
                'description' => 'Type I Portland Cement',
                'category_id' => $categories[0]->id,
                'unit_of_measure' => 'bag',
                'quantity_in_stock' => 100,
                'reorder_level' => 20,
                'unit_price' => 250.00,
            ]),
            Material::create([
                'sku' => 'SAND-001',
                'name' => 'Washed Sand',
                'description' => 'Fine washed sand for concrete',
                'category_id' => $categories[2]->id,
                'unit_of_measure' => 'kg',
                'quantity_in_stock' => 5000,
                'reorder_level' => 1000,
                'unit_price' => 5.00,
            ]),
            Material::create([
                'sku' => 'GRAVEL-001',
                'name' => 'Gravel (3/4")',
                'description' => 'Coarse gravel for concrete',
                'category_id' => $categories[2]->id,
                'unit_of_measure' => 'kg',
                'quantity_in_stock' => 8000,
                'reorder_level' => 2000,
                'unit_price' => 6.00,
            ]),
            Material::create([
                'sku' => 'REBAR-001',
                'name' => 'Steel Rebar 10mm',
                'description' => '10mm deformed steel rebar',
                'category_id' => $categories[1]->id,
                'unit_of_measure' => 'meter',
                'quantity_in_stock' => 500,
                'reorder_level' => 100,
                'unit_price' => 15.50,
            ]),
            Material::create([
                'sku' => 'BLOCK-001',
                'name' => 'Hollow Block (4")',
                'description' => '4" x 8" x 16" hollow blocks',
                'category_id' => $categories[3]->id,
                'unit_of_measure' => 'piece',
                'quantity_in_stock' => 2000,
                'reorder_level' => 500,
                'unit_price' => 8.50,
            ]),
            Material::create([
                'sku' => 'PAINT-001',
                'name' => 'Acrylic Paint White',
                'description' => 'Exterior acrylic paint - white',
                'category_id' => $categories[4]->id,
                'unit_of_measure' => 'gallon',
                'quantity_in_stock' => 50,
                'reorder_level' => 10,
                'unit_price' => 800.00,
            ]),
        ];

        // Attach suppliers to materials
        foreach ($materials as $material) {
            $material->suppliers()->create([
                'supplier_id' => $suppliers[0]->id,
                'supplier_price' => $material->unit_price * 0.95,
                'lead_time_days' => 3,
                'is_preferred' => true,
            ]);
            $material->suppliers()->create([
                'supplier_id' => $suppliers[1]->id,
                'supplier_price' => $material->unit_price,
                'lead_time_days' => 5,
                'is_preferred' => false,
            ]);
        }
    }
}
