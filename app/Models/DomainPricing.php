<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'tld',
        'register_price',
        'register_cost',
        'renew_price',
        'renew_cost',
        'transfer_price',
        'transfer_cost',
        'currency',
        'min_years',
        'max_years',
        'is_active',
    ];

    protected $casts = [
        'register_price' => 'decimal:2',
        'register_cost' => 'decimal:2',
        'renew_price' => 'decimal:2',
        'renew_cost' => 'decimal:2',
        'transfer_price' => 'decimal:2',
        'transfer_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
