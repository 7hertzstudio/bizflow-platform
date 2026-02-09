<?php

namespace App\Models;

use App\Enums\PlatformAdminRole;
use App\Enums\TenantRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'brand_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // Filament Tenancy Methods

    public function getTenants(Panel $panel): Collection
    {
        return $this->businesses;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        // Platform Super Admin can access all tenants for support
        if ($this->hasRole(PlatformAdminRole::SUPER_ADMIN->value)) {
            return true;
        }

        return $this->businesses->contains($tenant);
    }

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(TenantBusiness::class, 'tenant_business_user', 'user_id', 'tenant_business_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->hasRole(PlatformAdminRole::SUPER_ADMIN->value) || 
                   $this->hasRole(PlatformAdminRole::ADMIN->value) ||
                   $this->hasRole(PlatformAdminRole::MANAGER->value);
        }

        if ($panel->getId() === 'app') {
            // Platform Admins can also access App Panel (to view tenants)
            if ($this->hasRole(PlatformAdminRole::SUPER_ADMIN->value) || $this->hasRole(PlatformAdminRole::ADMIN->value)) {
                return true;
            }

            // Otherwise, must have a Tenant Role or be in the process of registration
            return $this->hasAnyRole(TenantRole::cases()) || $this->businesses()->exists(); 
        }

        return false;
    }
}