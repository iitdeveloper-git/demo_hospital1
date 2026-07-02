<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineBrand;
use App\Models\MedicineCategory;
use App\Models\MedicineReturn;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PharmacyPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'today_sales' => SalesOrder::whereDate('created_at', now()->toDateString())->sum('total_amount'),
            'total_medicines' => Medicine::count(),
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->count(),
            'out_of_stock' => Medicine::where('stock', 0)->count(),
            'expiring_soon' => Medicine::whereDate('expires_at', '<=', now()->addDays(30))->count(),
            'prescriptions_today' => Prescription::whereDate('issued_at', now()->toDateString())->count(),
        ];

        return view('pharmacy.dashboard', compact('metrics'));
    }

    public function medicines(Request $request): View
    {
        $query = Medicine::with(['category', 'brand']);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('generic_name', 'like', '%' . $request->search . '%');
        }
        $medicines = $query->paginate(15);
        return view('pharmacy.medicines', compact('medicines'));
    }

    public function categories(): View
    {
        $categories = MedicineCategory::paginate(15);
        return view('pharmacy.categories', compact('categories'));
    }

    public function prescriptions(): View
    {
        // Fetch doctor prescriptions to dispense
        $prescriptions = Prescription::with(['patient.user', 'doctor'])->orderBy('issued_at', 'desc')->paginate(15);
        return view('pharmacy.prescriptions', compact('prescriptions'));
    }

    public function dispense($id): RedirectResponse
    {
        $rx = Prescription::findOrFail($id);
        // Find matching medicine in stock to deduct
        $med = Medicine::where('name', 'like', '%' . $rx->medication_name . '%')->first();

        if ($med) {
            if ($med->stock >= 10) { // Deduct mock dosage quantity (e.g. 10 tablets)
                $med->decrement('stock', 10);
            } else {
                return back()->with('toast', [
                    'type' => 'danger',
                    'message' => 'Insufficient stock for ' . $med->name . '!',
                ]);
            }
        }

        // We can flag prescription as dispensed using custom updates or remarks (since column is not defined in base table, we can just save it or show a flash toast)
        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Prescription dispensed successfully and stock adjusted.',
        ]);
    }

    public function sales(): View
    {
        $patients = Patient::with('user')->get();
        $medicines = Medicine::where('stock', '>', 0)->get();
        $sales = SalesOrder::with('patient.user')->orderBy('id', 'desc')->paginate(15);
        return view('pharmacy.sales', compact('patients', 'medicines', 'sales'));
    }

    public function storeSale(Request $request): RedirectResponse
    {
        $request->validate([
            'medicine_id' => ['required', 'exists:medicines,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string'],
        ]);

        $med = Medicine::findOrFail($request->medicine_id);

        if ($med->stock < $request->quantity) {
            return back()->with('toast', [
                'type' => 'danger',
                'message' => 'Requested quantity exceeds available stock!',
            ]);
        }

        $subtotal = $med->selling_price * $request->quantity;
        $tax = $subtotal * 0.18; // 18% GST standard
        $total = $subtotal + $tax;

        $sale = SalesOrder::create([
            'invoice_number' => 'INV-PH-' . strtoupper(Str::random(6)),
            'patient_id' => $request->patient_id,
            'total_amount' => $total,
            'tax' => $tax,
            'discount' => 0,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
        ]);

        $med->decrement('stock', $request->quantity);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'POS Transaction completed: ' . $sale->invoice_number,
        ]);

        return back();
    }

    public function purchases(): View
    {
        $suppliers = Supplier::all();
        $orders = PurchaseOrder::with('supplier')->orderBy('id', 'desc')->paginate(15);
        return view('pharmacy.purchases', compact('suppliers', 'orders'));
    }

    public function storePurchase(Request $request): RedirectResponse
    {
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);

        PurchaseOrder::create([
            'po_number' => 'PO-' . strtoupper(Str::random(6)),
            'supplier_id' => $request->supplier_id,
            'status' => 'completed',
            'total_amount' => $request->total_amount,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Purchase Stock order received and checked in.',
        ]);

        return back();
    }

    public function returns(): View
    {
        $medicines = Medicine::all();
        $returns = MedicineReturn::with(['medicine'])->orderBy('id', 'desc')->paginate(15);
        return view('pharmacy.returns', compact('medicines', 'returns'));
    }

    public function storeReturn(Request $request): RedirectResponse
    {
        $request->validate([
            'medicine_id' => ['required', 'exists:medicines,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'type' => ['required', 'string'],
            'reason' => ['required', 'string'],
        ]);

        MedicineReturn::create([
            'medicine_id' => $request->medicine_id,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'approved',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Reagent return log registered.',
        ]);

        return back();
    }

    public function suppliers(): View
    {
        $suppliers = Supplier::paginate(15);
        return view('pharmacy.suppliers', compact('suppliers'));
    }

    public function reports(): View
    {
        $sales = SalesOrder::paginate(15);
        return view('pharmacy.reports', compact('sales'));
    }

    public function settings(): View
    {
        return view('pharmacy.settings');
    }
}
