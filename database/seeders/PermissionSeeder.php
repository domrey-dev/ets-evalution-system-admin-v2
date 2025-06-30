<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // List of all permissions
        $permissions = [
            // Dashboard
            'dashboard-view',

            // Roles
            'role-list', 'role-create', 'role-edit', 'role-delete', 'role-view',

            // Users
            'user-list', 'user-create', 'user-edit', 'user-delete', 'user-view',

            // Evaluations
            'evaluation', 'evaluation-form', 'evaluation-view', 'evaluation-delete',

            // Evaluation Room
            'evaluation-room-list', 'evaluation-room-create', 'evaluation-room-edit',
            'evaluation-room-delete', 'evaluation-room-view',

            // Evaluation Room types
            'evaluation-room-staff',
            'evaluation-room-self',
            'evaluation-room-final',
            'evaluation-room-submit',

            // Departments
            'department-list', 'department-create', 'department-edit',
            'department-delete', 'department-view',

            // Projects
            'project-list', 'project-create', 'project-edit',
            'project-delete', 'project-view',

            // Profile
            'profile-view', 'profile-edit', 'profile-delete'
        ];

        // Create permissions with guard 'web'
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'web']
            );
        }

        // Create admin role with guard 'web' and assign all permissions
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $admin->syncPermissions($permissions);

        // Create department role with evaluation permissions
        $department = Role::firstOrCreate([
            'name' => 'department',
            'guard_name' => 'web'
        ]);
        $department->syncPermissions([
            'dashboard-view',
            'evaluation', 'evaluation-form', 'evaluation-view',

            'evaluation-room-list',
            'evaluation-room-create',
            'evaluation-room-edit',
            'evaluation-room-delete',
            'evaluation-room-view',
            'evaluation-room-staff',
            'evaluation-room-self',
            'evaluation-room-final',
            'evaluation-room-submit',

            'profile-view', 'profile-edit'
        ]);

        // Create user role with basic evaluation permissions
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
        $userRole->syncPermissions([
            'dashboard-view',
            'evaluation-room-list',
            'evaluation-room-create',
            'evaluation-room-edit',
            'evaluation-room-delete',
            'evaluation-room-view',
            'evaluation-room-self',
            'evaluation-room-submit',
            'profile-view',
            'profile-edit'
        ]);

        // Assign admin role to user_id 1
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        // Assign department role to user_id 2
        $departmentUser = User::find(2);
        if ($departmentUser) {
            $departmentUser->assignRole('department');
        }

        // Assign user role to user_id 3
        $regularUser = User::find(3);
        if ($regularUser) {
            $regularUser->assignRole('user');
        }
    }
}