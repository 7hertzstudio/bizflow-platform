<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantBusinessNote extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'author_id',
        'title',
        'content',
        'type',
        'follow_up_date',
        'is_resolved',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'follow_up_date' => 'date',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class, 'tenant_business_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
