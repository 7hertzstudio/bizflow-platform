<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function impersonate(User $record): RedirectResponse
    {
        // Security Check: Only Super Admins can impersonate
        if (! Filament::auth()->user()->hasRole('platform_superadmin')) {
            abort(403);
        }

        // Save the original user ID
        session()->put('impersonator_id', Auth::id());

        // Login as the target user
        Auth::login($record);

        // Redirect to the App Panel (Tenant Dashboard)
        return redirect()->to('/app');
    }

    public function leave(): RedirectResponse
    {
        // Security Check: Must have an impersonator in session
        if (! session()->has('impersonator_id')) {
            abort(403);
        }

        // Login back as the original admin
        Auth::loginUsingId(session('impersonator_id'));

        // Clear the session
        session()->forget('impersonator_id');

        // Redirect back to Admin Panel
        return redirect()->to('/admin');
    }
}