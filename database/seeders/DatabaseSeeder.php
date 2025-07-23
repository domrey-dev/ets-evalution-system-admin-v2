<?php

namespace Database\Seeders;

use App\Constants\ConstUserRole;
use App\Models\Position;
use App\Models\Project;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First create the admin user without foreign key constraints
        $admin = User::factory()->create([
            'id' => 1,
            'name' => 'ETS Admin',
            'email' => 'admin@gmail.com',
            'role' => ConstUserRole::ADMIN,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => null,
            'position_id' => null,
            'project_id' => null,
        ]);

        // Create positions first
        $positions = [
            ['name' => 'Manager', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Developer', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Designer', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Tester', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];

        Position::insert($positions);

        // Now create other users with proper position references
        User::factory()->create([
            'id' => 2,
            'name' => 'ETS Department Manager',
            'email' => 'department@gmail.com',
            'role' => ConstUserRole::DEPARTMENT,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => null,
            'position_id' => 1,
            'project_id' => null,
        ]);

        User::factory()->create([
            'id' => 3,
            'name' => 'ETS Staff Member',
            'email' => 'user@gmail.com',
            'role' => ConstUserRole::USER,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => null,
            'position_id' => 2,
            'project_id' => null,
        ]);

        User::factory()->create([
            'id' => 4,
            'name' => 'John Developer',
            'email' => 'john@gmail.com',
            'role' => ConstUserRole::USER,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => null,
            'position_id' => 2,
            'project_id' => null,
        ]);

        User::factory()->create([
            'id' => 5,
            'name' => 'Sarah Designer',
            'email' => 'sarah@gmail.com',
            'role' => ConstUserRole::USER,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => null,
            'position_id' => 3,
            'project_id' => null,
        ]);

        // Update admin's position
        $admin->update(['position_id' => 1]);

        // Seed departments after users and positions are created
        $this->call(DepartmentSeeder::class);

        // Assign users to departments after departments are created
        $departments = \App\Models\Department::all();
        if ($departments->count() > 0) {
            // Assign first 3 users to first department
            User::whereIn('id', [1, 2, 3])->update(['department_id' => $departments->first()->id]);
            
            // Assign remaining users to second department (if exists)
            if ($departments->count() > 1) {
                User::whereIn('id', [4, 5])->update(['department_id' => $departments->skip(1)->first()->id]);
            }
        }

        // Create projects with tasks
        $numberOfProjects = 15;
        $tasksPerProject = 8;

        Project::factory()
            ->count($numberOfProjects)
            ->hasTasks($tasksPerProject)
            ->create();

        $this->call([
            PermissionSeeder::class,
        ]);

        $this->command->info("Created {$numberOfProjects} projects with {$tasksPerProject} tasks each.");
        $this->command->info("Total tasks: " . ($numberOfProjects * $tasksPerProject));
    }
}
