<?php

namespace App\Http\Controllers\Er;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ErAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && (Auth::user()->hasRole('doctor') || Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('hospital-admin'))) {
            return redirect()->route('er.dashboard');
        }
        return view('er.login');
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
            
            if ($user->hasRole('super-admin') || $user->hasRole('hospital-admin') || $user->hasRole('doctor')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Logged in to Critical Command: ' . $user->name,
                ]);

                return redirect()->intended(route('er.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to clinical administration accounts only.',
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

        return redirect()->route('er.login');
    }
}
