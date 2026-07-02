<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Doctor $doctor): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role?->slug === 'hospital-admin' || $user->role?->slug === 'super-admin';
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->role?->slug === 'hospital-admin' || $user->role?->slug === 'super-admin' || $user->id === $doctor->user_id;
    }

    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->role?->slug === 'hospital-admin' || $user->role?->slug === 'super-admin';
    }
}
