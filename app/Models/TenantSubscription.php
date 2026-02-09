<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantSubscription extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'product_plan_id',
        'is_bundle',
        'custom_name',
        'notes',
        'billing_interval',
        'total_amount',
        'currency',
        'status',
        'starts_at',
        'ends_at',
        'next_renewal_at',
        'canceled_at',
    ];

    protected $casts = [
        'is_bundle' => 'boolean',
        'total_amount' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'next_renewal_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(ProductPlan::class, 'product_plan_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TenantSubscriptionItem::class);
    }
}
