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
        $admin = User::factory()->create([
            'id' => 1,
            'name' => 'ETS Admin',
            'email' => 'admin@gmail.com',
            'role' => ConstUserRole::ADMIN,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 2, // Will need to exist after DepartmentSeeder runs
            'position_id' => 1,   // Will be created below
            'project_id' => 1,     // Will be created later
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'ETS Department',
            'email' => 'department@gmail.com',
            'role' => ConstUserRole::DEPARTMENT,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 3, // Will need to exist after DepartmentSeeder runs
            'position_id' => 1,   // Will be created below
            'project_id' => 1,     // Will be created later
        ]);

        User::factory()->create([
            'id' => 3,
            'name' => 'ETS User',
            'email' => 'user@gmail.com',
            'role' => ConstUserRole::USER,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'department_id' => 1, // Will need to exist after DepartmentSeeder runs
            'position_id' => 1,   // Will be created below
            'project_id' => 1,     // Will be created later
        ]);

        $positions = [
            ['name' => 'Manager', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Developer', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Designer', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Tester', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];

        Position::insert($positions);

        // Seed departments
        $this->call(DepartmentSeeder::class);

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
