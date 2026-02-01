<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TenantPlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPlanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TenantPlan');
    }

    public function view(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('View:TenantPlan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TenantPlan');
    }

    public function update(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('Update:TenantPlan');
    }

    public function delete(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('Delete:TenantPlan');
    }

    public function restore(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('Restore:TenantPlan');
    }

    public function forceDelete(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('ForceDelete:TenantPlan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TenantPlan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TenantPlan');
    }

    public function replicate(AuthUser $authUser, TenantPlan $tenantPlan): bool
    {
        return $authUser->can('Replicate:TenantPlan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TenantPlan');
    }

}