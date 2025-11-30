<?php

namespace Database\Seeders;

use App\Models\Worker;
use App\Models\WorkerCategory;
use App\Models\WorkerPosition;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            WorkerCategory::create(['name' => 'Skilled', 'description' => 'Highly trained professionals']),
            WorkerCategory::create(['name' => 'Semi-skilled', 'description' => 'Moderately trained workers']),
            WorkerCategory::create(['name' => 'Unskilled', 'description' => 'Laborers and helpers']),
            WorkerCategory::create(['name' => 'Supervisor', 'description' => 'Site supervisors and foremen']),
        ];

        // Create positions
        $positions = [
            WorkerPosition::create(['name' => 'Foreman', 'base_daily_rate' => 2500.00, 'description' => 'Site supervisor']),
            WorkerPosition::create(['name' => 'Mason', 'base_daily_rate' => 1500.00, 'description' => 'Bricklaying specialist']),
            WorkerPosition::create(['name' => 'Carpenter', 'base_daily_rate' => 1400.00, 'description' => 'Wood framing and finishing']),
            WorkerPosition::create(['name' => 'Electrician', 'base_daily_rate' => 1800.00, 'description' => 'Electrical installation']),
            WorkerPosition::create(['name' => 'Plumber', 'base_daily_rate' => 1700.00, 'description' => 'Plumbing installation']),
            WorkerPosition::create(['name' => 'Laborer', 'base_daily_rate' => 800.00, 'description' => 'General labor']),
        ];

        // Create sample workers
        $workers = [
            Worker::create([
                'worker_id' => 'EMP-001',
                'first_name' => 'Juan',
                'last_name' => 'Santos',
                'email' => 'juan@example.com',
                'phone' => '555-0001',
                'position_id' => $positions[0]->id,
                'category_id' => $categories[3]->id,
                'hire_date' => now()->subYears(5),
                'status' => 'Active',
            ]),
            Worker::create([
                'worker_id' => 'EMP-002',
                'first_name' => 'Maria',
                'last_name' => 'Cruz',
                'email' => 'maria@example.com',
                'phone' => '555-0002',
                'position_id' => $positions[1]->id,
                'category_id' => $categories[0]->id,
                'hire_date' => now()->subYears(3),
                'status' => 'Active',
            ]),
            Worker::create([
                'worker_id' => 'EMP-003',
                'first_name' => 'Pedro',
                'last_name' => 'Garcia',
                'email' => 'pedro@example.com',
                'phone' => '555-0003',
                'position_id' => $positions[2]->id,
                'category_id' => $categories[0]->id,
                'hire_date' => now()->subYears(2),
                'status' => 'Active',
            ]),
            Worker::create([
                'worker_id' => 'EMP-004',
                'first_name' => 'Luis',
                'last_name' => 'Lopez',
                'email' => 'luis@example.com',
                'phone' => '555-0004',
                'position_id' => $positions[3]->id,
                'category_id' => $categories[0]->id,
                'hire_date' => now()->subYears(4),
                'status' => 'Active',
            ]),
            Worker::create([
                'worker_id' => 'EMP-005',
                'first_name' => 'Ana',
                'last_name' => 'Rodriguez',
                'email' => 'ana@example.com',
                'phone' => '555-0005',
                'position_id' => $positions[5]->id,
                'category_id' => $categories[2]->id,
                'hire_date' => now()->subMonths(6),
                'status' => 'Active',
            ]),
        ];

        // Add emergency contacts
        foreach ($workers as $worker) {
            $worker->emergencyContact()->create([
                'contact_name' => 'Spouse',
                'relationship' => 'Spouse',
                'phone' => '555-XXXX',
            ]);
        }

        // Add skills
        $workers[0]->skills()->create([
            'skill_name' => 'Site Management',
            'proficiency' => 'Expert',
        ]);
        $workers[1]->skills()->create([
            'skill_name' => 'Masonry',
            'proficiency' => 'Expert',
            'certification_expiry' => now()->addYears(1),
        ]);
        $workers[2]->skills()->create([
            'skill_name' => 'Carpentry',
            'proficiency' => 'Expert',
        ]);
        $workers[3]->skills()->create([
            'skill_name' => 'Electrical Work',
            'proficiency' => 'Expert',
            'certification_expiry' => now()->addMonths(2),
        ]);
    }
}
