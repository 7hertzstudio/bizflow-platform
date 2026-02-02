<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TenantInvoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantInvoicePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TenantInvoice');
    }

    public function view(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('View:TenantInvoice');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TenantInvoice');
    }

    public function update(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('Update:TenantInvoice');
    }

    public function delete(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('Delete:TenantInvoice');
    }

    public function restore(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('Restore:TenantInvoice');
    }

    public function forceDelete(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('ForceDelete:TenantInvoice');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TenantInvoice');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TenantInvoice');
    }

    public function replicate(AuthUser $authUser, TenantInvoice $tenantInvoice): bool
    {
        return $authUser->can('Replicate:TenantInvoice');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TenantInvoice');
    }

}