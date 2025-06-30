<?php

namespace Database\Seeders;

use App\Containers\User\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User management permissions
            ['name' => 'users.view', 'description' => 'View users'],
            ['name' => 'users.create', 'description' => 'Create users'],
            ['name' => 'users.edit', 'description' => 'Edit users'],
            ['name' => 'users.delete', 'description' => 'Delete users'],
            ['name' => 'users.export', 'description' => 'Export users'],
            
            // Blog management permissions
            ['name' => 'blogs.view', 'description' => 'View blogs'],
            ['name' => 'blogs.create', 'description' => 'Create blogs'],
            ['name' => 'blogs.edit', 'description' => 'Edit blogs'],
            ['name' => 'blogs.delete', 'description' => 'Delete blogs'],
            ['name' => 'blogs.publish', 'description' => 'Publish blogs'],
            ['name' => 'blogs.approve', 'description' => 'Approve blogs'],
            
            // System permissions
            ['name' => 'dashboard.view', 'description' => 'View dashboard'],
            ['name' => 'settings.view', 'description' => 'View settings'],
            ['name' => 'settings.edit', 'description' => 'Edit settings'],
            ['name' => 'logs.view', 'description' => 'View system logs'],
            ['name' => 'reports.view', 'description' => 'View reports'],
            ['name' => 'reports.generate', 'description' => 'Generate reports'],
            
            // Role-based permissions
            ['name' => 'admin.access', 'description' => 'Access admin panel'],
            ['name' => 'manager.access', 'description' => 'Access manager panel'],
            ['name' => 'user.access', 'description' => 'Access user panel'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
