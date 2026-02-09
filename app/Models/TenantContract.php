<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantContract extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'tenant_quote_id',
        'template_contract_id',
        'title',
        'content',
        'status',
        'signed_at',
        'signer_ip',
        'signer_name',
        'pdf_path',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(TenantProject::class);
    }
}
