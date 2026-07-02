<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReceptionAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && Auth::user()->hasRole('receptionist')) {
            return redirect()->route('reception.dashboard');
        }
        return view('reception.login');
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
            
            if ($user->hasRole('receptionist')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Logged in to Reception Command: ' . $user->name,
                ]);

                return redirect()->intended(route('reception.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to receptionist staff accounts only.',
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

        return redirect()->route('reception.login');
    }
}
