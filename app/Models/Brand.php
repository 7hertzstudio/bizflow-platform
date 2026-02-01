<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'website',
        'email',
        'phone',
        'logo',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'tax_id',
        'currency',
        'bank_details',
    ];

    protected $casts = [
        'bank_details' => 'array',
    ];
}