<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductPlan extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price_monthly',
        'compare_at_price_monthly',
        'price_yearly',
        'compare_at_price_yearly',
        'currency',
        'is_custom',
        'features',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'is_custom' => 'boolean',
        'price_monthly' => 'integer',
        'price_yearly' => 'integer',
        'compare_at_price_monthly' => 'integer',
        'compare_at_price_yearly' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'product_plan_promotion');
    }
}
