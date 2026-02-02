<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantInvoice extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'quote_id',
        'invoice_number',
        'currency',
        'exchange_rate',
        'has_master_discount',
        'master_discount_type',
        'master_discount_value',
        'subtotal',
        'discount_total',
        'tax_total',
        'rounding_adjustment',
        'total',
        'status',
        'due_date',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'has_master_discount' => 'boolean',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'exchange_rate' => 'decimal:6',
        'master_discount_value' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'rounding_adjustment' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(TenantQuote::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TenantInvoiceItem::class);
    }
}