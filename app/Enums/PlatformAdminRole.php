<?php

namespace App\Enums;

enum PlatformAdminRole: string
{
    case SUPER_ADMIN = 'platform_superadmin';
    case ADMIN = 'platform_admin';
    case MANAGER = 'platform_manager';
}
