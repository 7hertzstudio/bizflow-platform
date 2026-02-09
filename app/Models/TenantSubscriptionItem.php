<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantSubscriptionItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_subscription_id',
        'product_plan_id',
        'original_price',
    ];

    protected $casts = [
        'original_price' => 'integer',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(TenantSubscription::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(ProductPlan::class, 'product_plan_id');
    }
}
