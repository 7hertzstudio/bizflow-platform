<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TenantBusiness extends Model
{
    use HasFactory, HasUlids, LogsActivity;

    protected $fillable = [
        'brand_id',
        'owner_id',
        'name',
        'slug',
        'billing_currency',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_business_user', 'tenant_business_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(TenantBusinessAddress::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TenantBusinessNote::class);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(TenantDomain::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(TenantSubscription::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(TenantInvoice::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(TenantQuote::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(TenantContract::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(TenantProject::class);
    }

    public function credentials(): HasMany
    {
        return $this->hasMany(TenantCredential::class);
    }

    public function scheduledReports(): HasMany
    {
        return $this->hasMany(TenantScheduledReport::class);
    }
}
