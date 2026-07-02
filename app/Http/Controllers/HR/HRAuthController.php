<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HRAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && (Auth::user()->hasRole('hr-manager') || Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('hospital-admin'))) {
            return redirect()->route('hr.dashboard');
        }
        return view('hr.login');
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
            
            if ($user->hasRole('super-admin') || $user->hasRole('hospital-admin') || $user->hasRole('hr-manager')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Logged in to HR Command: ' . $user->name,
                ]);

                return redirect()->intended(route('hr.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to human resource administration accounts only.',
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

        return redirect()->route('hr.login');
    }
}
