<?php

namespace Database\Seeders;

use App\Enums\PlatformAdminRole;
use App\Enums\TenantRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Platform Admin Roles
        foreach (PlatformAdminRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }

        // Create Tenant Roles
        foreach (TenantRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }
        
        // Example permission
        Permission::firstOrCreate(['name' => 'view_finance']);
    }
}