<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantProject extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_business_id',
        'tenant_contract_id',
        'manager_id',
        'name',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'budget' => 'integer',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(TenantBusiness::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
