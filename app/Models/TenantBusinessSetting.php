<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantBusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_business_id',
        'logo',
        'theme',
        'billing_info',
        'notification_settings',
    ];

    protected $casts = [
        'theme' => 'array',
        'billing_info' => 'array',
        'notification_settings' => 'array',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }
}