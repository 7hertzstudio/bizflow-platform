<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantDomain extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'domain',
        'is_verified',
        'verification_token',
        'dns_settings',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'dns_settings' => 'array',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }
}