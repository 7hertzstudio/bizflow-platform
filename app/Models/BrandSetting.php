<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BrandSetting extends Model
{
    use HasUlids;
    protected $fillable = ['brand_id', 'group', 'key', 'value', 'is_public'];
    protected $casts = ['is_public' => 'boolean'];
}
