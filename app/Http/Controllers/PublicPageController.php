<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\DoctorRepository;
use Illuminate\Contracts\View\View;

class PublicPageController extends Controller
{
    public function __construct(private readonly DoctorRepository $doctors)
    {
    }

    public function home(): View
    {
        return view('public.home', [
            'departments' => Department::query()->where('is_active', true)->limit(8)->get(),
            'doctors' => $this->doctors->featured(),
            'meta' => [
                'title' => 'AarogyaCare - Advanced AI Powered Hospital Management System',
                'description' => 'Premium hospital management platform for appointments, EMR, pharmacy, billing, lab, inventory, and AI-assisted care operations.',
            ],
        ]);
    }

    public function page(string $page): View
    {
        abort_unless(in_array($page, config('AarogyaCare.public_pages'), true), 404);

        $viewName = view()->exists("public.{$page}") ? "public.{$page}" : "public.page";

        $meta = [
            'title' => str($page)->replace('-', ' ')->title().' | AarogyaCare',
            'description' => 'Explore AarogyaCare '.str($page)->replace('-', ' ').' resources.',
        ];

        if ($page === 'about') {
            $meta = [
                'title' => 'About AarogyaCare | Advanced Hospital & Healthcare Services',
                'description' => 'Learn about AarogyaCare, our mission, experienced doctors, advanced facilities, patient-first philosophy and world-class healthcare services.',
            ];
        }

        $extraData = [];
        if ($page === 'appointment') {
            $extraData['departments'] = Department::query()->where('is_active', true)->orderBy('name')->get();
            $extraData['doctors'] = \App\Models\Doctor::query()->with(['user', 'department'])->get();
            $meta = [
                'title' => 'Book an Appointment Online | AarogyaCare',
                'description' => 'Book your specialist care consultation or priority OPD check-up online with AarogyaCare.',
            ];
        }

        return view($viewName, array_merge([
            'page' => $page,
            'title' => str($page)->replace('-', ' ')->title(),
            'meta' => $meta,
        ], $extraData));
    }
}
