<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantInvoiceItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_invoice_id',
        'tenant_plan_id',
        'description',
        'qty',
        'unit_price',
        'use_master_discount',
        'custom_discount_type',
        'custom_discount_value',
        'row_total',
    ];

    protected $casts = [
        'use_master_discount' => 'boolean',
        'unit_price' => 'decimal:2',
        'custom_discount_value' => 'decimal:2',
        'row_total' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(TenantInvoice::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(TenantPlan::class);
    }
}