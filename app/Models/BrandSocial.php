<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BrandSocial extends Model
{
    use HasUlids;
    protected $fillable = ['brand_id', 'platform', 'url', 'label', 'order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
