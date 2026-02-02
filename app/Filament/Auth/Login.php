<?php

namespace App\Filament\Auth;

use App\Enums\PlatformAdminRole;
use App\Enums\TenantRole;
use App\Models\User;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // 1. Verify Credentials without logging in
        if (! Filament::auth()->validate($this->getCredentialsFromFormData($data))) {
            $this->throwFailureValidationException();
        }

        // 2. Get the User
        $user = User::where('email', $data['email'])->first();
        $panelId = Filament::getCurrentPanel()->getId();

        $platformRoles = array_map(fn ($case) => $case->value, PlatformAdminRole::cases());
        $tenantRoles = array_map(fn ($case) => $case->value, TenantRole::cases());

        // 3. Perform Role Checks
        
        // 🔒 SCENARIO 1: App Portal Login (/login)
        if ($panelId === 'app') {
            if ($user->hasAnyRole($platformRoles)) {
                // If they don't have a Tenant role or a business, block them
                if (! $user->hasAnyRole($tenantRoles) && ! $user->businesses()->exists()) {
                    throw ValidationException::withMessages([
                        'data.email' => __('Admins must login via the Admin Portal.'),
                    ]);
                }
            }
        }

        // 🔒 SCENARIO 2: Admin Portal Login (/admin/login)
        if ($panelId === 'admin') {
            if (! $user->hasAnyRole($platformRoles)) {
                throw ValidationException::withMessages([
                    'data.email' => __('Tenants must login via the App Portal.'),
                ]);
            }
        }

        // 4. If we pass, proceed with standard authentication
        return parent::authenticate();
    }
}
