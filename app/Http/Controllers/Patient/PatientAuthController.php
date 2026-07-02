<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PatientAuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::check() && Auth::user()->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        }
        return view('patient.login');
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
            
            if ($user->hasRole('patient')) {
                $request->session()->regenerate();
                
                $request->session()->flash('toast', [
                    'type' => 'success',
                    'message' => 'Welcome back, ' . $user->name . '!',
                ]);

                return redirect()->intended(route('patient.dashboard'));
            }

            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This login is restricted to patient accounts only.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        if (Auth::check() && Auth::user()->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        }
        return view('patient.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:male,female,non-binary'],
            'blood_group' => ['nullable', 'string', 'max:5'],
            'emergency_contact' => ['required', 'string', 'max:20'],
            'insurance_provider' => ['nullable', 'string', 'max:100'],
        ]);

        $patientRole = Role::where('slug', 'patient')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $patientRole->id,
            'status' => 'active',
        ]);

        // Generate patient code
        $latestPatient = Patient::orderBy('id', 'desc')->first();
        $nextNumber = $latestPatient ? ((int) str_replace('PAT-', '', $latestPatient->patient_code)) + 1 : 1;
        $patientCode = 'PAT-' . str_pad((string)$nextNumber, 6, '0', STR_PAD_LEFT);

        Patient::create([
            'user_id' => $user->id,
            'patient_code' => $patientCode,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'emergency_contact' => $request->emergency_contact,
            'insurance_provider' => $request->insurance_provider,
        ]);

        Auth::login($user);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Registration successful! Welcome to AarogyaCare.',
        ]);

        return redirect()->route('patient.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('patient.login');
    }
}
