<?php

namespace Database\Seeders;

use App\Enums\PlatformAdminRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'jawad@7hertzstudio.com'],
            [
                'name' => 'Jawad',
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole(PlatformAdminRole::SUPER_ADMIN->value);
    }
}
