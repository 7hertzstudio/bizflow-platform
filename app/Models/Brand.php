<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'website',
        'email',
        'phone',
        'logo',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'tax_id',
        'currency',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(BrandSetting::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(BrandContact::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(BrandSocial::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(BrandPaymentMethod::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(TenantBusiness::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}
