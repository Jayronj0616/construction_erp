<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample clients
        $clients = [
            Client::create(['name' => 'Client A', 'email' => 'clienta@example.com', 'phone' => '555-0001']),
            Client::create(['name' => 'City Hall', 'email' => 'cityhall@example.com', 'phone' => '555-0002']),
            Client::create(['name' => 'XYZ Corp', 'email' => 'xyz@example.com', 'phone' => '555-0003']),
        ];

        // Get a user to assign as manager (or create one)
        $manager = User::first() ?? User::create([
            'name' => 'Project Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample projects
        Project::create([
            'name' => 'House Renovation',
            'description' => 'Complete renovation of residential property',
            'client_id' => $clients[0]->id,
            'location' => '123 Main St, Downtown',
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonths(1),
            'budget' => 500000,
            'status' => 'Active',
            'progress' => 65,
            'manager_id' => $manager->id,
        ]);

        Project::create([
            'name' => 'Road Repair',
            'description' => 'Highway maintenance and repair project',
            'client_id' => $clients[1]->id,
            'location' => 'Highway 101, North Section',
            'start_date' => now()->subMonths(1),
            'end_date' => now()->addMonths(3),
            'budget' => 2000000,
            'status' => 'Active',
            'progress' => 40,
            'manager_id' => $manager->id,
        ]);

        Project::create([
            'name' => 'Warehouse Construction',
            'description' => 'New commercial warehouse facility',
            'client_id' => $clients[2]->id,
            'location' => '456 Industrial Blvd, Business Park',
            'start_date' => now()->addMonths(1),
            'end_date' => now()->addMonths(6),
            'budget' => 1500000,
            'status' => 'Planning',
            'progress' => 10,
            'manager_id' => $manager->id,
        ]);
    }
}
