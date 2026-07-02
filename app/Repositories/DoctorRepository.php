<?php

namespace App\Repositories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;

class DoctorRepository
{
    public function featured(): Collection
    {
        return Doctor::query()
            ->with(['user', 'department'])
            ->orderByDesc('rating')
            ->limit(6)
            ->get();
    }
}
