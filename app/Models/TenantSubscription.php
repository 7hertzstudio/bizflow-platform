<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantSubscription extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'tenant_plan_id',
        'price_at_subscription',
        'currency_at_subscription',
        'exchange_rate_used',
        'status',
        'starts_at',
        'ends_at',
        'canceled_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(TenantPlan::class, 'tenant_plan_id');
    }
}