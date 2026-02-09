<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BrandContact extends Model
{
    use HasUlids;
    protected $fillable = ['brand_id', 'type', 'value', 'label', 'is_primary', 'is_public'];
    protected $casts = ['is_primary' => 'boolean', 'is_public' => 'boolean'];
}
