<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. 7 Hertz Studio
        Brand::firstOrCreate(
            ['slug' => '7-hertz-studio'],
            [
                'name' => '7 Hertz Studio',
                'website' => 'https://7hertzstudio.com',
                'email' => 'contact@7hertzstudio.com',
                'phone' => '+1234567890',
                'address_line_1' => '123 Creative Ave',
                'city' => 'Design City',
                'state' => 'CA',
                'zip' => '90210',
                'country' => 'USA',
                'currency' => 'USD',
                'bank_details' => [
                    'Bank Name' => 'Silicon Valley Bank',
                    'Account Number' => '123456789',
                    'Routing Number' => '987654321',
                    'SWIFT' => 'SVBUS33',
                ],
            ]
        );

        // 2. YourStore.pk
        Brand::firstOrCreate(
            ['slug' => 'yourstore-pk'],
            [
                'name' => 'YourStore.pk',
                'website' => 'https://yourstore.pk',
                'email' => 'support@yourstore.pk',
                'phone' => '+923001234567',
                'address_line_1' => '456 Market St',
                'city' => 'Lahore',
                'state' => 'Punjab',
                'zip' => '54000',
                'country' => 'Pakistan',
                'currency' => 'PKR',
                'bank_details' => [
                    'Bank Name' => 'Meezan Bank',
                    'Account Number' => 'PK12MEZN0000000123456789',
                    'Account Title' => 'YourStore PK',
                ],
            ]
        );
    }
}