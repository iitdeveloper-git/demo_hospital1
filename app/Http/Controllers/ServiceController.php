<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::query()->where('status', 'active')->with('department');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('full_description', 'like', "%{$search}%");
            });
        }

        // Department/Category Filter
        if ($request->filled('department')) {
            $deptSlug = $request->input('department');
            $query->whereHas('department', function ($q) use ($deptSlug) {
                $q->where('slug', $deptSlug);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'default');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_from', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_from', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $services = $query->paginate(9)->withQueryString();
        $departments = Department::query()->where('is_active', true)->get();

        return view('services.index', [
            'services' => $services,
            'departments' => $departments,
            'meta' => [
                'title' => 'Healthcare Services & Treatments | AarogyaCare',
                'description' => 'Explore our range of premium, advanced medical services spanning Cardiology, Neurology, Orthopedics, and more.',
            ]
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::query()->where('slug', $slug)->where('status', 'active')->with('department')->firstOrFail();

        // Related Services (in same department, excluding current, limit 3)
        $relatedServices = Service::query()
            ->where('department_id', $service->department_id)
            ->where('id', '!=', $service->id)
            ->where('status', 'active')
            ->limit(3)
            ->get();

        // Related Doctors (in same department, limit 3)
        $relatedDoctors = Doctor::query()
            ->where('department_id', $service->department_id)
            ->with('user')
            ->limit(3)
            ->get();

        return view('services.show', [
            'service' => $service,
            'relatedServices' => $relatedServices,
            'relatedDoctors' => $relatedDoctors,
            'meta' => [
                'title' => $service->meta_title ?? "{$service->title} | AarogyaCare",
                'description' => $service->meta_description ?? $service->short_description,
            ]
        ]);
    }
}
