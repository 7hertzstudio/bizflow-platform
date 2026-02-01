<?php

namespace Database\Seeders;

use App\Enums\TenantRole;
use App\Models\TenantBusiness;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = [
            [
                'name' => 'TechNova Solutions',
                'slug' => 'technova',
                'billing_currency' => 'PKR',
                'country' => 'PK',
                'status' => 'active',
                'prefix' => 'technova',
            ],
            [
                'name' => 'Global Imports Inc',
                'slug' => 'global-imports',
                'billing_currency' => 'USD',
                'country' => 'US',
                'status' => 'active',
                'prefix' => 'global',
            ],
        ];

        foreach ($businesses as $data) {
            $prefix = $data['prefix'];
            unset($data['prefix']);

            // Create Owner User
            $ownerEmail = "{$prefix}_owner@example.com";
            $owner = User::firstOrCreate(
                ['email' => $ownerEmail],
                [
                    'name' => "{$data['name']} Owner",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $owner->assignRole(TenantRole::ADMIN->value);

            // Create Business
            $business = TenantBusiness::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['owner_id' => $owner->id])
            );

            // Attach Owner as Tenant Admin
            if (! $business->users()->where('user_id', $owner->id)->exists()) {
                $business->users()->attach($owner->id, ['role' => TenantRole::ADMIN->value]);
            }

            // Create other roles
            foreach (TenantRole::cases() as $role) {
                if ($role === TenantRole::ADMIN) {
                    continue; // Already created owner as admin
                }

                $roleName = $role->value; // e.g. tenant_manager
                $shortRole = str_replace('tenant_', '', $roleName); // e.g. manager
                $email = "{$prefix}_{$shortRole}@example.com";

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => "{$data['name']} " . ucfirst($shortRole),
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );

                // Assign global role (Spatie)
                $user->assignRole($role->value);

                // Attach to business with specific role
                if (! $business->users()->where('user_id', $user->id)->exists()) {
                    $business->users()->attach($user->id, ['role' => $role->value]);
                }
            }
        }
    }
}