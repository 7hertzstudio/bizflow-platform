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
        'renew_price',
        'transfer_price',
        'currency',
        'min_years',
        'max_years',
        'is_active',
    ];

    protected $casts = [
        'register_price' => 'decimal:2',
        'renew_price' => 'decimal:2',
        'transfer_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}