<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TenantDomain extends Model
{
    use HasFactory, HasUlids, LogsActivity;

    protected $fillable = [
        'tenant_business_id',
        'domain',
        'registrar',
        'is_managed',
        'auto_renew',
        'cost_price',
        'sell_price',
        'currency',
        'registered_at',
        'expires_at',
        'status',
        'notes',
        'is_verified',
        'verification_token',
        'dns_settings',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_managed' => 'boolean',
        'auto_renew' => 'boolean',
        'registered_at' => 'date',
        'expires_at' => 'date',
        'dns_settings' => 'array',
        'cost_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }
}