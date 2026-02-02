<?php

namespace App\Http\Responses;

use App\Enums\PlatformAdminRole;
use App\Enums\TenantRole;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = Filament::auth()->user();
        $panelId = Filament::getCurrentPanel()->getId();

        $platformRoles = array_map(fn ($case) => $case->value, PlatformAdminRole::cases());
        $tenantRoles = array_map(fn ($case) => $case->value, TenantRole::cases());

        // 🔒 SCENARIO 1: App Portal Login (/login)
        if ($panelId === 'app') {
            if ($user->hasAnyRole($platformRoles)) {
                if (!$user->hasAnyRole($tenantRoles) && !$user->businesses()->exists()) {
                    Auth::logout();
                    
                    Notification::make()
                        ->title('Access Denied')
                        ->body('Admins must login via the Admin Portal.')
                        ->danger()
                        ->send();

                    return redirect()->to('/admin/login');
                }
            }

            $latestBusiness = $user->businesses()->latest()->first();
            if ($latestBusiness) {
                return redirect()->to('/app/' . $latestBusiness->slug);
            }
        }

        // 🔒 SCENARIO 2: Admin Portal Login (/admin/login)
        if ($panelId === 'admin') {
            if (!$user->hasAnyRole($platformRoles)) {
                Auth::logout();

                Notification::make()
                    ->title('Access Denied')
                    ->body('Tenants must login via the App Portal.')
                    ->danger()
                    ->send();

                return redirect()->to('/login');
            }
        }

        return redirect()->intended(Filament::getUrl());
    }
}
