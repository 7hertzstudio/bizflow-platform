<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TenantSubscription;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantSubscriptionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TenantSubscription');
    }

    public function view(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('View:TenantSubscription');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TenantSubscription');
    }

    public function update(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('Update:TenantSubscription');
    }

    public function delete(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('Delete:TenantSubscription');
    }

    public function restore(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('Restore:TenantSubscription');
    }

    public function forceDelete(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('ForceDelete:TenantSubscription');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TenantSubscription');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TenantSubscription');
    }

    public function replicate(AuthUser $authUser, TenantSubscription $tenantSubscription): bool
    {
        return $authUser->can('Replicate:TenantSubscription');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TenantSubscription');
    }

}