<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TenantBusiness;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantBusinessPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TenantBusiness');
    }

    public function view(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('View:TenantBusiness');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TenantBusiness');
    }

    public function update(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('Update:TenantBusiness');
    }

    public function delete(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('Delete:TenantBusiness');
    }

    public function restore(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('Restore:TenantBusiness');
    }

    public function forceDelete(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('ForceDelete:TenantBusiness');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TenantBusiness');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TenantBusiness');
    }

    public function replicate(AuthUser $authUser, TenantBusiness $tenantBusiness): bool
    {
        return $authUser->can('Replicate:TenantBusiness');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TenantBusiness');
    }

}