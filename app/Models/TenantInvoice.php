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
        'brand_id',
        'tenant_business_id',
        'invoice_number',
        'tenant_quote_id',
        'reference_id',
        'reference_type',
        'subtotal',
        'tax_total',
        'discount_total',
        'total',
        'amount_paid',
        'currency',
        'status',
        'issue_date',
        'due_date',
        'paid_at',
        'pdf_path',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax_total' => 'integer',
        'discount_total' => 'integer',
        'total' => 'integer',
        'amount_paid' => 'integer',
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TenantInvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TenantPayment::class);
    }
}