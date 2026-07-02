<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BillingAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && (Auth::user()->hasRole('accountant') || Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('hospital-admin'))) {
            return redirect()->route('billing.dashboard');
        }
        return view('billing.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Allow hospital-admin, super-admin, receptionist, or accountant
            if ($user->hasRole('super-admin') || $user->hasRole('hospital-admin') || $user->hasRole('receptionist') || $user->hasRole('accountant')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Logged in to Financial Command: ' . $user->name,
                ]);

                return redirect()->route('billing.dashboard');
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to financial administration accounts only.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('billing.login');
    }
}
