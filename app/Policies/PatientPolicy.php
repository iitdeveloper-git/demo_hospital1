<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function view(User $user, Patient $patient): bool
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('hospital-admin')
            || $patient->user_id === $user->id;
    }
}
