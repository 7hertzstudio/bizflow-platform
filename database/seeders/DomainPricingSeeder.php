<?php

namespace Database\Seeders;

use App\Models\DomainPricing;
use Illuminate\Database\Seeder;

class DomainPricingSeeder extends Seeder
{
    public function run(): void
    {
        $pricings = [
            [
                'tld' => 'com',
                'register_price' => 17.00,
                'renew_price' => 17.00,
                'transfer_price' => 15.00,
                'currency' => 'USD',
                'min_years' => 1,
                'max_years' => 10,
            ],
            [
                'tld' => 'net',
                'register_price' => 20.00,
                'renew_price' => 20.00,
                'transfer_price' => 18.00,
                'currency' => 'USD',
                'min_years' => 1,
                'max_years' => 10,
            ],
            [
                'tld' => 'org',
                'register_price' => 18.00,
                'renew_price' => 18.00,
                'transfer_price' => 16.00,
                'currency' => 'USD',
                'min_years' => 1,
                'max_years' => 10,
            ],
            [
                'tld' => 'pk',
                'register_price' => 1800.00,
                'renew_price' => 1800.00,
                'transfer_price' => 0.00, // Transfers usually free or specific rules
                'currency' => 'PKR',
                'min_years' => 2,
                'max_years' => 5,
            ],
            [
                'tld' => 'com.pk',
                'register_price' => 1800.00,
                'renew_price' => 1800.00,
                'transfer_price' => 0.00,
                'currency' => 'PKR',
                'min_years' => 2,
                'max_years' => 5,
            ],
        ];

        foreach ($pricings as $pricing) {
            DomainPricing::updateOrCreate(['tld' => $pricing['tld']], $pricing);
        }
    }
}