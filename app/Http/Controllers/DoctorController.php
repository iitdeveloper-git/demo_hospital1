<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Doctor::query()->where('status', 'active')->with('department');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('qualification', 'like', "%{$search}%")
                  ->orWhere('education', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Department Filter
        if ($request->filled('department')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('slug', $request->input('department'));
            });
        }

        // Gender Filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Experience Filter (e.g. 5+, 10+, 15+)
        if ($request->filled('experience')) {
            $exp = (int) $request->input('experience');
            $query->where('experience_years', '>=', $exp);
        }

        // Availability Filter
        if ($request->filled('available_today')) {
            $query->where('available_today', true);
        }

        // Video Consultation Filter
        if ($request->filled('video_consultation')) {
            $query->where('video_consultation', true);
        }

        // Rating Filter (e.g. 4+, 4.5+)
        if ($request->filled('rating')) {
            $rating = (float) $request->input('rating');
            $query->where('rating', '>=', $rating);
        }

        // Sorting
        $sort = $request->input('sort', 'rating_desc');
        switch ($sort) {
            case 'experience_desc':
                $query->orderBy('experience_years', 'desc');
                break;
            case 'fee_asc':
                $query->orderBy('consultation_fee', 'asc');
                break;
            case 'fee_desc':
                $query->orderBy('consultation_fee', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('full_name', 'asc');
                break;
            default:
                $query->orderBy('rating', 'desc');
                break;
        }

        $doctors = $query->paginate(9)->withQueryString();
        $departments = Department::query()->where('is_active', true)->get();

        return view('doctors.index', [
            'doctors' => $doctors,
            'departments' => $departments,
            'meta' => [
                'title' => 'Specialist Doctors & Clinicians | AarogyaCare',
                'description' => 'Find and book appointments online with our highly experienced specialist doctors and critical care clinicians.',
            ]
        ]);
    }

    public function show(string $slug): View
    {
        $doctor = Doctor::query()->where('slug', $slug)->where('status', 'active')->with(['department', 'reviews'])->firstOrFail();

        // Related Doctors (same department, limit 3)
        $relatedDoctors = Doctor::query()
            ->where('department_id', $doctor->department_id)
            ->where('id', '!=', $doctor->id)
            ->where('status', 'active')
            ->limit(3)
            ->get();

        return view('doctors.show', [
            'doctor' => $doctor,
            'relatedDoctors' => $relatedDoctors,
            'meta' => [
                'title' => $doctor->meta_title ?? "{$doctor->full_name} | {$doctor->specialization} | AarogyaCare",
                'description' => $doctor->meta_description ?? $doctor->bio,
            ]
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->input('query');
        $doctors = Doctor::query()
            ->where('status', 'active')
            ->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('name', 'like', "%{$search}%");
                  });
            })
            ->with('department')
            ->limit(5)
            ->get();

        return response()->json($doctors);
    }
}
