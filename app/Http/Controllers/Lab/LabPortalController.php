<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\LabEquipment;
use App\Models\LabOrder;
use App\Models\LabTest;
use App\Models\LabTestCategory;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\QualityControlLog;
use App\Models\Reagent;
use App\Models\SampleCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LabPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'today_tests' => LabOrder::whereDate('created_at', now()->toDateString())->count(),
            'pending_samples' => SampleCollection::where('status', 'collected')->count(),
            'processing_samples' => SampleCollection::where('status', 'processing')->count(),
            'completed_reports' => MedicalReport::where('report_type', 'lab')->where('status', 'final')->count(),
            'critical_reports' => MedicalReport::where('report_type', 'lab')->where('summary', 'like', '%critical%')->count(),
        ];

        return view('laboratory.dashboard', compact('metrics'));
    }

    public function testCategories(Request $request): View
    {
        $categories = LabTestCategory::paginate(15);
        return view('laboratory.test-categories', compact('categories'));
    }

    public function tests(Request $request): View
    {
        $query = LabTest::with('category');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('test_code', 'like', '%' . $request->search . '%');
        }
        $tests = $query->paginate(15);
        return view('laboratory.tests', compact('tests'));
    }

    public function orders(Request $request): View
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $orders = LabOrder::with(['patient.user', 'doctor'])->orderBy('id', 'desc')->paginate(15);
        return view('laboratory.orders', compact('patients', 'doctors', 'orders'));
    }

    public function storeOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'priority' => ['required', 'string'],
        ]);

        LabOrder::create([
            'order_number' => 'LAB-' . strtoupper(Str::random(6)),
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'LIMS Test Order created successfully!',
        ]);

        return back();
    }

    public function samples(): View
    {
        $orders = LabOrder::where('status', 'pending')->get();
        $samples = SampleCollection::with(['labOrder.patient.user'])->orderBy('id', 'desc')->paginate(15);
        return view('laboratory.samples', compact('orders', 'samples'));
    }

    public function storeSample(Request $request): RedirectResponse
    {
        $request->validate([
            'lab_order_id' => ['required', 'exists:lab_orders,id'],
            'sample_type' => ['required', 'string'],
        ]);

        $order = LabOrder::findOrFail($request->lab_order_id);

        SampleCollection::create([
            'lab_order_id' => $order->id,
            'sample_id' => 'SMP-' . strtoupper(Str::random(6)),
            'sample_type' => $request->sample_type,
            'collection_date' => now(),
            'notes' => $request->notes,
            'status' => 'collected',
        ]);

        $order->update(['status' => 'processing']);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Sample collected and registered under LIMS!',
        ]);

        return back();
    }

    public function updateSampleStatus(Request $request, $id): RedirectResponse
    {
        $sample = SampleCollection::findOrFail($id);
        $sample->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            $sample->labOrder->update(['status' => 'completed']);
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Sample status updated to: ' . ucfirst($request->status),
        ]);
    }

    public function reports(): View
    {
        $reports = MedicalReport::where('report_type', 'lab')->orderBy('id', 'desc')->paginate(15);
        return view('laboratory.reports', compact('reports'));
    }

    public function equipment(): View
    {
        $equipments = LabEquipment::paginate(15);
        return view('laboratory.equipment', compact('equipments'));
    }

    public function reagents(): View
    {
        $reagents = Reagent::paginate(15);
        return view('laboratory.reagents', compact('reagents'));
    }

    public function qualityControl(): View
    {
        $logs = QualityControlLog::with('equipment')->paginate(15);
        return view('laboratory.quality-control', compact('logs'));
    }

    public function profile(): View
    {
        return view('laboratory.profile');
    }
}
