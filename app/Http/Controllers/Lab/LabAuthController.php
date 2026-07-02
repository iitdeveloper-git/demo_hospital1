<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LabAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && (Auth::user()->hasRole('laboratory') || Auth::user()->hasRole('lab-technician'))) {
            return redirect()->route('laboratory.dashboard');
        }
        return view('laboratory.login');
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
            
            if ($user->hasRole('laboratory') || $user->hasRole('lab-technician')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Logged in to LIMS: ' . $user->name,
                ]);

                return redirect()->intended(route('laboratory.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to laboratory staff accounts only.',
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

        return redirect()->route('laboratory.login');
    }
}
