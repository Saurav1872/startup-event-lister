<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create events',
            'edit events',
            'delete events',
            'publish events',
            'view all events',
            'manage categories',
            'manage tags',
            'manage users',
            'manage registrations',
            'manage reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $organizer = Role::firstOrCreate(['name' => 'organizer']);
        $organizer->syncPermissions([
            'create events',
            'edit events',
            'delete events',
            'publish events',
            'view all events',
            'manage registrations',
        ]);

        $attendee = Role::firstOrCreate(['name' => 'attendee']);
        $attendee->syncPermissions([
            'view all events',
        ]);
    }
} 