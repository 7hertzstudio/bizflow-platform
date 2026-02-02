<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TenantQuote;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantQuotePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TenantQuote');
    }

    public function view(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('View:TenantQuote');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TenantQuote');
    }

    public function update(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('Update:TenantQuote');
    }

    public function delete(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('Delete:TenantQuote');
    }

    public function restore(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('Restore:TenantQuote');
    }

    public function forceDelete(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('ForceDelete:TenantQuote');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TenantQuote');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TenantQuote');
    }

    public function replicate(AuthUser $authUser, TenantQuote $tenantQuote): bool
    {
        return $authUser->can('Replicate:TenantQuote');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TenantQuote');
    }

}