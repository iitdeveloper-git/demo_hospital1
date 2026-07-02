<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\HospitalPackage;
use App\Models\InsuranceClaim;
use App\Models\InsuranceCompany;
use App\Models\InvoiceHeader;
use App\Models\InvoiceItem;
use App\Models\JournalEntry;
use App\Models\LedgerAccount;
use App\Models\Patient;
use App\Models\PatientWallet;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BillingPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'today_revenue' => Payment::whereDate('created_at', now()->toDateString())->sum('amount'),
            'monthly_revenue' => Payment::whereMonth('created_at', now()->month)->sum('amount'),
            'outstanding' => InvoiceHeader::where('status', 'pending')->sum('grand_total'),
            'pending_refunds' => Refund::where('status', 'pending')->sum('amount'),
            'claims_count' => InsuranceClaim::count(),
            'wallet_balances' => PatientWallet::sum('balance'),
        ];

        return view('billing.dashboard', compact('metrics'));
    }

    public function invoices(Request $request): View
    {
        $query = InvoiceHeader::with(['patient.user']);
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('patient.user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $invoices = $query->paginate(15);
        return view('billing.invoices', compact('invoices'));
    }

    public function create(): View
    {
        $patients = Patient::with('user')->get();
        return view('billing.create', compact('patients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'item_name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $subtotal = $request->price * 1; // quantity 1
        $tax = $subtotal * 0.18; // 18% GST standard
        $grand_total = $subtotal + $tax;

        $invoice = InvoiceHeader::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
            'patient_id' => $request->patient_id,
            'total_amount' => $subtotal,
            'tax' => $tax,
            'discount' => 0,
            'grand_total' => $grand_total,
            'status' => 'pending',
        ]);

        InvoiceItem::create([
            'invoice_header_id' => $invoice->id,
            'item_name' => $request->item_name,
            'quantity' => 1,
            'price' => $request->price,
            'subtotal' => $subtotal,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Invoice ' . $invoice->invoice_number . ' generated successfully!',
        ]);

        return redirect()->route('billing.invoices');
    }

    public function payments(): View
    {
        $invoices = InvoiceHeader::where('status', 'pending')->get();
        $payments = Payment::with('invoiceHeader.patient.user')->orderBy('id', 'desc')->paginate(15);
        return view('billing.payments', compact('invoices', 'payments'));
    }

    public function storePayment(Request $request): RedirectResponse
    {
        $request->validate([
            'invoice_header_id' => ['required', 'exists:invoice_headers,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string'],
        ]);

        $invoice = InvoiceHeader::findOrFail($request->invoice_header_id);

        Payment::create([
            'invoice_header_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_reference' => 'TXN-' . strtoupper(Str::random(6)),
            'status' => 'completed',
        ]);

        $invoice->update(['status' => 'paid']);

        // Post Journal Entry (Double entry check)
        $cashAccount = LedgerAccount::firstOrCreate(['code' => '1001', 'name' => 'Cash/Bank Account', 'type' => 'asset']);
        $revenueAccount = LedgerAccount::firstOrCreate(['code' => '4001', 'name' => 'Outpatient Revenue', 'type' => 'income']);

        JournalEntry::create([
            'ledger_account_id' => $cashAccount->id,
            'debit_amount' => $request->amount,
            'credit_amount' => 0,
            'description' => 'Received payment against ' . $invoice->invoice_number,
        ]);

        JournalEntry::create([
            'ledger_account_id' => $revenueAccount->id,
            'debit_amount' => 0,
            'credit_amount' => $request->amount,
            'description' => 'Revenue recognized against ' . $invoice->invoice_number,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Payment registered and accounting ledgers updated.',
        ]);

        return back();
    }

    public function refunds(): View
    {
        $payments = Payment::all();
        $refunds = Refund::with('payment.invoiceHeader.patient.user')->orderBy('id', 'desc')->paginate(15);
        return view('billing.refunds', compact('payments', 'refunds'));
    }

    public function storeRefund(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_id' => ['required', 'exists:payments,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'reason' => ['required', 'string'],
        ]);

        Refund::create([
            'payment_id' => $request->payment_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'status' => 'approved',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Refund processed successfully.',
        ]);

        return back();
    }

    public function insurance(): View
    {
        $companies = InsuranceCompany::all();
        $invoices = InvoiceHeader::all();
        $claims = InsuranceClaim::with(['invoiceHeader.patient.user', 'company'])->orderBy('id', 'desc')->paginate(15);
        return view('billing.insurance', compact('companies', 'invoices', 'claims'));
    }

    public function storeClaim(Request $request): RedirectResponse
    {
        $request->validate([
            'invoice_header_id' => ['required', 'exists:invoice_headers,id'],
            'company_id' => ['required', 'exists:insurance_companies,id'],
            'policy_number' => ['required', 'string'],
            'claim_amount' => ['required', 'numeric', 'min:0'],
        ]);

        InsuranceClaim::create([
            'invoice_header_id' => $request->invoice_header_id,
            'company_id' => $request->company_id,
            'policy_number' => $request->policy_number,
            'claim_amount' => $request->claim_amount,
            'status' => 'pending',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Insurance Claim dispatched to provider.',
        ]);

        return back();
    }

    public function accounts(): View
    {
        $entries = JournalEntry::with('ledgerAccount')->orderBy('id', 'desc')->paginate(30);
        return view('billing.accounts', compact('entries'));
    }

    public function ledgers(): View
    {
        $accounts = LedgerAccount::with('journalEntries')->paginate(15);
        return view('billing.ledgers', compact('accounts'));
    }

    public function packages(): View
    {
        $packages = HospitalPackage::paginate(15);
        return view('billing.packages', compact('packages'));
    }

    public function storePackage(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:hospital_packages,name'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        HospitalPackage::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Hospital package configured.',
        ]);

        return back();
    }

    public function reports(): View
    {
        $payments = Payment::paginate(15);
        return view('billing.reports', compact('payments'));
    }

    public function settings(): View
    {
        return view('billing.settings');
    }
}
