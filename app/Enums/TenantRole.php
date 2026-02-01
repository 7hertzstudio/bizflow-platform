<?php

namespace App\Enums;

enum TenantRole: string
{
    case ADMIN = 'tenant_admin';
    case MANAGER = 'tenant_manager';
    case ACCOUNTANT = 'tenant_accountant';
    case IT = 'tenant_it';
    case CREATOR = 'tenant_creator';
}