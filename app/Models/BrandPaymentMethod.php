<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BrandPaymentMethod extends Model
{
    use HasUlids;
    protected $fillable = ['brand_id', 'type', 'label', 'details', 'currency', 'is_primary', 'is_active'];
    protected $casts = ['details' => 'array', 'is_primary' => 'boolean', 'is_active' => 'boolean'];
}
