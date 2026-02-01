<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantPlan extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'brand_id',
        'name',
        'category',
        'base_price',
        'base_currency',
        'is_custom',
        'features',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'is_custom' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(TenantSubscription::class);
    }
}