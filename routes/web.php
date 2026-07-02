<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::post('/appointments', [AppointmentController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('appointments.store');

Route::get('/portal/{role}', [DashboardController::class, 'show'])
    ->whereIn('role', array_keys(config('AarogyaCare.roles')))
    ->name('dashboard.role');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctor/search', [DoctorController::class, 'search'])->name('doctors.search');
Route::get('/doctors/{slug}', [DoctorController::class, 'show'])->name('doctors.show');

// Patient Portal Routes
Route::prefix('patient')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Patient\PatientAuthController::class, 'showLogin'])->name('patient.login');
        Route::post('/login', [\App\Http\Controllers\Patient\PatientAuthController::class, 'login']);
        Route::get('/register', [\App\Http\Controllers\Patient\PatientAuthController::class, 'showRegister'])->name('patient.register');
        Route::post('/register', [\App\Http\Controllers\Patient\PatientAuthController::class, 'register']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:patient'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Patient\PatientAuthController::class, 'logout'])->name('patient.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Patient\PatientPortalController::class, 'dashboard'])->name('patient.dashboard');
        Route::get('/profile', [\App\Http\Controllers\Patient\PatientPortalController::class, 'profile'])->name('patient.profile');
        Route::get('/appointments', [\App\Http\Controllers\Patient\PatientPortalController::class, 'appointments'])->name('patient.appointments');
        Route::get('/medical-history', [\App\Http\Controllers\Patient\PatientPortalController::class, 'medicalHistory'])->name('patient.medical-history');
        Route::get('/reports', [\App\Http\Controllers\Patient\PatientPortalController::class, 'reports'])->name('patient.reports');
        Route::get('/prescriptions', [\App\Http\Controllers\Patient\PatientPortalController::class, 'prescriptions'])->name('patient.prescriptions');
        Route::get('/payments', [\App\Http\Controllers\Patient\PatientPortalController::class, 'payments'])->name('patient.payments');
        Route::get('/insurance', [\App\Http\Controllers\Patient\PatientPortalController::class, 'insurance'])->name('patient.insurance');
        Route::get('/settings', [\App\Http\Controllers\Patient\PatientPortalController::class, 'settings'])->name('patient.settings');
        Route::post('/settings', [\App\Http\Controllers\Patient\PatientPortalController::class, 'updateSettings'])->name('patient.settings.update');
    });
});

// Doctor Portal Routes
Route::prefix('doctor')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Doctor\DoctorAuthController::class, 'showLogin'])->name('doctor.login');
        Route::post('/login', [\App\Http\Controllers\Doctor\DoctorAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:doctor'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Doctor\DoctorAuthController::class, 'logout'])->name('doctor.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'dashboard'])->name('doctor.dashboard');
        Route::get('/profile', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'profile'])->name('doctor.profile');
        Route::get('/schedule', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'schedule'])->name('doctor.schedule');
        
        Route::get('/appointments', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'appointments'])->name('doctor.appointments');
        Route::post('/appointments/{id}', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'updateAppointment'])->name('doctor.appointments.update');
        
        Route::get('/patients', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'patients'])->name('doctor.patients');
        Route::get('/patient/{id}', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'patientShow'])->name('doctor.patient.show');
        Route::post('/patient/{id}/vitals', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'addVitals'])->name('doctor.patient.vitals');
        
        Route::get('/prescriptions', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'prescriptions'])->name('doctor.prescriptions');
        Route::post('/prescriptions', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'storePrescription'])->name('doctor.prescriptions.store');
        
        Route::get('/reports', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'reports'])->name('doctor.reports');
        Route::post('/reports', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'uploadReport'])->name('doctor.reports.upload');
        Route::post('/reports/{id}/approve', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'approveReport'])->name('doctor.reports.approve');
        
        Route::get('/messages', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'messages'])->name('doctor.messages');
        Route::post('/messages', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'sendMessage'])->name('doctor.messages.send');
        
        Route::get('/settings', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'settings'])->name('doctor.settings');
        Route::post('/settings', [\App\Http\Controllers\Doctor\DoctorPortalController::class, 'updateSettings'])->name('doctor.settings.update');
    });
});

// Admin Portal Routes
Route::prefix('admin')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:super-admin,hospital-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminPortalController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [\App\Http\Controllers\Admin\AdminPortalController::class, 'profile'])->name('admin.profile');
        
        Route::get('/settings', [\App\Http\Controllers\Admin\AdminPortalController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [\App\Http\Controllers\Admin\AdminPortalController::class, 'updateSettings'])->name('admin.settings.update');
        
        Route::get('/users', [\App\Http\Controllers\Admin\AdminPortalController::class, 'users'])->name('admin.users');
        Route::get('/doctors', [\App\Http\Controllers\Admin\AdminPortalController::class, 'doctors'])->name('admin.doctors');
        Route::get('/patients', [\App\Http\Controllers\Admin\AdminPortalController::class, 'patients'])->name('admin.patients');
        Route::get('/departments', [\App\Http\Controllers\Admin\AdminPortalController::class, 'departments'])->name('admin.departments');
        Route::get('/appointments', [\App\Http\Controllers\Admin\AdminPortalController::class, 'appointments'])->name('admin.appointments');
        Route::get('/reports', [\App\Http\Controllers\Admin\AdminPortalController::class, 'reports'])->name('admin.reports');
        
        // Modules architecture
        Route::get('/pharmacy', [\App\Http\Controllers\Admin\AdminPortalController::class, 'pharmacy'])->name('admin.pharmacy');
        Route::get('/laboratory', [\App\Http\Controllers\Admin\AdminPortalController::class, 'laboratory'])->name('admin.laboratory');
        Route::get('/billing', [\App\Http\Controllers\Admin\AdminPortalController::class, 'billing'])->name('admin.billing');
        Route::get('/inventory', [\App\Http\Controllers\Admin\AdminPortalController::class, 'inventory'])->name('admin.inventory');
        Route::get('/employees', [\App\Http\Controllers\Admin\AdminPortalController::class, 'employees'])->name('admin.employees');
        Route::get('/insurance', [\App\Http\Controllers\Admin\AdminPortalController::class, 'insurance'])->name('admin.insurance');
        
        // CMS Management
        Route::get('/blog', [\App\Http\Controllers\Admin\AdminPortalController::class, 'blog'])->name('admin.blog');
        Route::get('/gallery', [\App\Http\Controllers\Admin\AdminPortalController::class, 'gallery'])->name('admin.gallery');
        Route::get('/testimonials', [\App\Http\Controllers\Admin\AdminPortalController::class, 'testimonials'])->name('admin.testimonials');
        Route::get('/faqs', [\App\Http\Controllers\Admin\AdminPortalController::class, 'faqs'])->name('admin.faqs');
        
        Route::get('/activity-logs', [\App\Http\Controllers\Admin\AdminPortalController::class, 'activityLogs'])->name('admin.activity-logs');
        Route::get('/system-health', [\App\Http\Controllers\Admin\AdminPortalController::class, 'systemHealth'])->name('admin.system-health');
    });
});

// Reception Portal Routes
Route::prefix('reception')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Reception\ReceptionAuthController::class, 'showLogin'])->name('reception.login');
        Route::post('/login', [\App\Http\Controllers\Reception\ReceptionAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:receptionist'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Reception\ReceptionAuthController::class, 'logout'])->name('reception.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'dashboard'])->name('reception.dashboard');
        Route::get('/profile', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'profile'])->name('reception.profile');
        
        Route::get('/patients', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'patients'])->name('reception.patients');
        Route::get('/new-patient', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'newPatient'])->name('reception.new-patient');
        Route::post('/new-patient', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'storePatient']);
        
        Route::get('/walk-in', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'walkIn'])->name('reception.walk-in');
        Route::post('/walk-in', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'storeWalkIn']);
        
        Route::get('/appointments', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'appointments'])->name('reception.appointments');
        Route::post('/check-in/{id}', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'checkIn'])->name('reception.check-in');
        Route::post('/check-out/{id}', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'checkOut'])->name('reception.check-out');
        
        Route::get('/queue', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'queue'])->name('reception.queue');
        
        Route::get('/visitors', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'visitors'])->name('reception.visitors');
        Route::post('/visitors', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'storeVisitor'])->name('reception.visitors.store');
        
        Route::get('/admissions', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'admissions'])->name('reception.admissions');
        Route::post('/admissions', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'storeAdmission'])->name('reception.admissions.store');
        
        Route::get('/payments', [\App\Http\Controllers\Reception\ReceptionPortalController::class, 'payments'])->name('reception.payments');
    });
});

// LIMS Portal Routes
Route::prefix('laboratory')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Lab\LabAuthController::class, 'showLogin'])->name('laboratory.login');
        Route::post('/login', [\App\Http\Controllers\Lab\LabAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:laboratory,lab-technician,super-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Lab\LabAuthController::class, 'logout'])->name('laboratory.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Lab\LabPortalController::class, 'dashboard'])->name('laboratory.dashboard');
        Route::get('/profile', [\App\Http\Controllers\Lab\LabPortalController::class, 'profile'])->name('laboratory.profile');
        
        Route::get('/test-categories', [\App\Http\Controllers\Lab\LabPortalController::class, 'testCategories'])->name('laboratory.test-categories');
        Route::get('/tests', [\App\Http\Controllers\Lab\LabPortalController::class, 'tests'])->name('laboratory.tests');
        
        Route::get('/orders', [\App\Http\Controllers\Lab\LabPortalController::class, 'orders'])->name('laboratory.orders');
        Route::post('/orders', [\App\Http\Controllers\Lab\LabPortalController::class, 'storeOrder'])->name('laboratory.orders.store');
        
        Route::get('/samples', [\App\Http\Controllers\Lab\LabPortalController::class, 'samples'])->name('laboratory.samples');
        Route::post('/samples', [\App\Http\Controllers\Lab\LabPortalController::class, 'storeSample'])->name('laboratory.samples.store');
        Route::post('/samples/{id}/status', [\App\Http\Controllers\Lab\LabPortalController::class, 'updateSampleStatus'])->name('laboratory.samples.status');
        
        Route::get('/reports', [\App\Http\Controllers\Lab\LabPortalController::class, 'reports'])->name('laboratory.reports');
        Route::get('/equipment', [\App\Http\Controllers\Lab\LabPortalController::class, 'equipment'])->name('laboratory.equipment');
        Route::get('/reagents', [\App\Http\Controllers\Lab\LabPortalController::class, 'reagents'])->name('laboratory.reagents');
        Route::get('/quality-control', [\App\Http\Controllers\Lab\LabPortalController::class, 'qualityControl'])->name('laboratory.quality-control');
    });
});

// Pharmacy Portal Routes
Route::prefix('pharmacy')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Pharmacy\PharmacyAuthController::class, 'showLogin'])->name('pharmacy.login');
        Route::post('/login', [\App\Http\Controllers\Pharmacy\PharmacyAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:pharmacist,super-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Pharmacy\PharmacyAuthController::class, 'logout'])->name('pharmacy.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'dashboard'])->name('pharmacy.dashboard');
        
        Route::get('/medicines', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'medicines'])->name('pharmacy.medicines');
        Route::get('/categories', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'categories'])->name('pharmacy.categories');
        
        Route::get('/prescriptions', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'prescriptions'])->name('pharmacy.prescriptions');
        Route::post('/prescriptions/{id}/dispense', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'dispense'])->name('pharmacy.prescriptions.dispense');
        
        Route::get('/sales', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'sales'])->name('pharmacy.sales');
        Route::post('/sales', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'storeSale'])->name('pharmacy.sales.store');
        
        Route::get('/purchases', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'purchases'])->name('pharmacy.purchases');
        Route::post('/purchases', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'storePurchase'])->name('pharmacy.purchases.store');
        
        Route::get('/returns', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'returns'])->name('pharmacy.returns');
        Route::post('/returns', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'storeReturn'])->name('pharmacy.returns.store');
        
        Route::get('/suppliers', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'suppliers'])->name('pharmacy.suppliers');
        Route::get('/reports', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'reports'])->name('pharmacy.reports');
        Route::get('/settings', [\App\Http\Controllers\Pharmacy\PharmacyPortalController::class, 'settings'])->name('pharmacy.settings');
    });
});

// Billing Portal Routes
Route::prefix('billing')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Billing\BillingAuthController::class, 'showLogin'])->name('billing.login');
        Route::post('/login', [\App\Http\Controllers\Billing\BillingAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:accountant,receptionist,super-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Billing\BillingAuthController::class, 'logout'])->name('billing.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Billing\BillingPortalController::class, 'dashboard'])->name('billing.dashboard');
        
        Route::get('/invoices', [\App\Http\Controllers\Billing\BillingPortalController::class, 'invoices'])->name('billing.invoices');
        Route::get('/create', [\App\Http\Controllers\Billing\BillingPortalController::class, 'create'])->name('billing.create');
        Route::post('/create', [\App\Http\Controllers\Billing\BillingPortalController::class, 'store']);
        
        Route::get('/payments', [\App\Http\Controllers\Billing\BillingPortalController::class, 'payments'])->name('billing.payments');
        Route::post('/payments', [\App\Http\Controllers\Billing\BillingPortalController::class, 'storePayment'])->name('billing.payments.store');
        
        Route::get('/refunds', [\App\Http\Controllers\Billing\BillingPortalController::class, 'refunds'])->name('billing.refunds');
        Route::post('/refunds', [\App\Http\Controllers\Billing\BillingPortalController::class, 'storeRefund'])->name('billing.refunds.store');
        
        Route::get('/insurance', [\App\Http\Controllers\Billing\BillingPortalController::class, 'insurance'])->name('billing.insurance');
        Route::post('/insurance', [\App\Http\Controllers\Billing\BillingPortalController::class, 'storeClaim'])->name('billing.insurance.store');
        
        Route::get('/accounts', [\App\Http\Controllers\Billing\BillingPortalController::class, 'accounts'])->name('billing.accounts');
        Route::get('/ledgers', [\App\Http\Controllers\Billing\BillingPortalController::class, 'ledgers'])->name('billing.ledgers');
        
        Route::get('/packages', [\App\Http\Controllers\Billing\BillingPortalController::class, 'packages'])->name('billing.packages');
        Route::post('/packages', [\App\Http\Controllers\Billing\BillingPortalController::class, 'storePackage'])->name('billing.packages.store');
        
        Route::get('/reports', [\App\Http\Controllers\Billing\BillingPortalController::class, 'reports'])->name('billing.reports');
        Route::get('/settings', [\App\Http\Controllers\Billing\BillingPortalController::class, 'settings'])->name('billing.settings');
    });
});

// Inventory Portal Routes
Route::prefix('inventory')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Inventory\InventoryAuthController::class, 'showLogin'])->name('inventory.login');
        Route::post('/login', [\App\Http\Controllers\Inventory\InventoryAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:inventory-manager,super-admin,hospital-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Inventory\InventoryAuthController::class, 'logout'])->name('inventory.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'dashboard'])->name('inventory.dashboard');
        
        Route::get('/items', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'items'])->name('inventory.items');
        Route::get('/categories', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'categories'])->name('inventory.categories');
        
        Route::get('/assets', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'assets'])->name('inventory.assets');
        Route::post('/assets', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'storeAsset']);
        
        Route::get('/equipment', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'equipment'])->name('inventory.equipment');
        Route::post('/equipment', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'storeEquipment']);
        
        Route::get('/beds', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'beds'])->name('inventory.beds');
        Route::get('/wards', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'wards'])->name('inventory.wards');
        
        Route::get('/purchase-orders', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'purchaseOrders'])->name('inventory.purchase-orders');
        
        Route::get('/goods-receipt', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'goodsReceipt'])->name('inventory.goods-receipt');
        Route::post('/goods-receipt', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'storeReceipt'])->name('inventory.goods-receipt.store');
        
        Route::get('/transfers', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'transfers'])->name('inventory.transfers');
        Route::get('/vendors', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'vendors'])->name('inventory.vendors');
        
        Route::get('/maintenance', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'maintenance'])->name('inventory.maintenance');
        Route::post('/maintenance', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'storeMaintenance']);
        
        Route::get('/reports', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'reports'])->name('inventory.reports');
        Route::get('/settings', [\App\Http\Controllers\Inventory\InventoryPortalController::class, 'settings'])->name('inventory.settings');
    });
});

// HRMS Portal Routes
Route::prefix('hr')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\HR\HRAuthController::class, 'showLogin'])->name('hr.login');
        Route::post('/login', [\App\Http\Controllers\HR\HRAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:hr-manager,super-admin,hospital-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\HR\HRAuthController::class, 'logout'])->name('hr.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\HR\HRPortalController::class, 'dashboard'])->name('hr.dashboard');
        
        Route::get('/employees', [\App\Http\Controllers\HR\HRPortalController::class, 'employees'])->name('hr.employees');
        Route::post('/employees', [\App\Http\Controllers\HR\HRPortalController::class, 'storeEmployee']);
        
        Route::get('/departments', [\App\Http\Controllers\HR\HRPortalController::class, 'departments'])->name('hr.departments');
        Route::get('/designations', [\App\Http\Controllers\HR\HRPortalController::class, 'designations'])->name('hr.designations');
        
        Route::get('/attendance', [\App\Http\Controllers\HR\HRPortalController::class, 'attendance'])->name('hr.attendance');
        Route::get('/shifts', [\App\Http\Controllers\HR\HRPortalController::class, 'shifts'])->name('hr.shifts');
        
        Route::get('/leave', [\App\Http\Controllers\HR\HRPortalController::class, 'leave'])->name('hr.leave');
        Route::post('/leave/{id}/approve', [\App\Http\Controllers\HR\HRPortalController::class, 'approveLeave'])->name('hr.leave.approve');
        Route::post('/leave/{id}/reject', [\App\Http\Controllers\HR\HRPortalController::class, 'rejectLeave'])->name('hr.leave.reject');
        
        Route::get('/payroll', [\App\Http\Controllers\HR\HRPortalController::class, 'payroll'])->name('hr.payroll');
        Route::post('/payroll', [\App\Http\Controllers\HR\HRPortalController::class, 'storePayroll'])->name('hr.payroll.store');
        Route::post('/payroll/{id}/pay', [\App\Http\Controllers\HR\HRPortalController::class, 'payPayroll'])->name('hr.payroll.pay');
        
        Route::get('/reports', [\App\Http\Controllers\HR\HRPortalController::class, 'reports'])->name('hr.reports');
        Route::get('/settings', [\App\Http\Controllers\HR\HRPortalController::class, 'settings'])->name('hr.settings');
    });
});

// ER Portal Routes
Route::prefix('er')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Er\ErAuthController::class, 'showLogin'])->name('er.login');
        Route::post('/login', [\App\Http\Controllers\Er\ErAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware(['auth', 'role:doctor,super-admin,hospital-admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Er\ErAuthController::class, 'logout'])->name('er.logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Er\ErPortalController::class, 'dashboard'])->name('er.dashboard');
        
        Route::get('/patients', [\App\Http\Controllers\Er\ErPortalController::class, 'patients'])->name('er.patients');
        Route::post('/patients', [\App\Http\Controllers\Er\ErPortalController::class, 'storePatient']);
        
        Route::get('/triage', [\App\Http\Controllers\Er\ErPortalController::class, 'triage'])->name('er.triage');
        Route::post('/triage', [\App\Http\Controllers\Er\ErPortalController::class, 'storeTriage']);
        
        Route::get('/ambulance', [\App\Http\Controllers\Er\ErPortalController::class, 'ambulance'])->name('er.ambulance');
        Route::get('/icu', [\App\Http\Controllers\Er\ErPortalController::class, 'icu'])->name('er.icu');
        Route::get('/beds', [\App\Http\Controllers\Er\ErPortalController::class, 'beds'])->name('er.beds');
        
        Route::get('/operation-theatre', [\App\Http\Controllers\Er\ErPortalController::class, 'operationTheatre'])->name('er.operation-theatre');
        Route::post('/operation-theatre', [\App\Http\Controllers\Er\ErPortalController::class, 'storeOt']);
        
        Route::get('/emergency-alerts', [\App\Http\Controllers\Er\ErPortalController::class, 'emergencyAlerts'])->name('er.emergency-alerts');
        Route::post('/emergency-alerts/code-blue', [\App\Http\Controllers\Er\ErPortalController::class, 'triggerCodeBlue'])->name('er.emergency-alerts.code-blue');
        Route::post('/emergency-alerts/disaster', [\App\Http\Controllers\Er\ErPortalController::class, 'triggerDisaster'])->name('er.emergency-alerts.disaster');
        
        Route::get('/reports', [\App\Http\Controllers\Er\ErPortalController::class, 'reports'])->name('er.reports');
    });
});

// AI & CDSS Module Routes
Route::prefix('ai')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Ai\AiDashboardController::class, 'index'])->name('ai.dashboard');
    Route::get('/chat', [\App\Http\Controllers\Ai\AiChatController::class, 'index'])->name('ai.chat');
    Route::post('/chat', [\App\Http\Controllers\Ai\AiChatController::class, 'store'])->name('ai.chat.store');
    Route::post('/chat/{id}/feedback', [\App\Http\Controllers\Ai\AiChatController::class, 'feedback'])->name('ai.chat.feedback');

    Route::get('/patient-summary', [\App\Http\Controllers\Ai\CdssToolController::class, 'patientSummary'])->name('ai.patient-summary');
    Route::get('/symptom-checker', [\App\Http\Controllers\Ai\CdssToolController::class, 'symptomChecker'])->name('ai.symptom-checker');
    Route::post('/symptom-checker', [\App\Http\Controllers\Ai\CdssToolController::class, 'postSymptomChecker'])->name('ai.symptom-checker.post');
    Route::get('/lab-insights', [\App\Http\Controllers\Ai\CdssToolController::class, 'labInsights'])->name('ai.lab-insights');
    Route::get('/radiology-insights', [\App\Http\Controllers\Ai\CdssToolController::class, 'radiologyInsights'])->name('ai.radiology-insights');
    Route::get('/prescription-review', [\App\Http\Controllers\Ai\CdssToolController::class, 'prescriptionReview'])->name('ai.prescription-review');
    Route::get('/drug-interactions', [\App\Http\Controllers\Ai\CdssToolController::class, 'drugInteractions'])->name('ai.drug-interactions');
    Route::post('/drug-interactions', [\App\Http\Controllers\Ai\CdssToolController::class, 'postDrugInteractions'])->name('ai.drug-interactions.post');
    Route::get('/risk-score', [\App\Http\Controllers\Ai\CdssToolController::class, 'riskScore'])->name('ai.risk-score');
    Route::get('/alerts', [\App\Http\Controllers\Ai\CdssToolController::class, 'alerts'])->name('ai.alerts');
    Route::post('/alerts/{id}/resolve', [\App\Http\Controllers\Ai\CdssToolController::class, 'resolveAlert'])->name('ai.alerts.resolve');
    Route::get('/settings', [\App\Http\Controllers\Ai\CdssToolController::class, 'settings'])->name('ai.settings');
    Route::post('/settings', [\App\Http\Controllers\Ai\CdssToolController::class, 'updateSettings'])->name('ai.settings.update');
    Route::get('/prompts', [\App\Http\Controllers\Ai\CdssToolController::class, 'prompts'])->name('ai.prompts');
    Route::post('/prompts', [\App\Http\Controllers\Ai\CdssToolController::class, 'updatePrompt'])->name('ai.prompts.update');
});

// Business Intelligence & Executive Analytics Routes
Route::prefix('analytics')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/revenue', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'revenue'])->name('analytics.revenue');
    Route::get('/patients', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'patients'])->name('analytics.patients');
    Route::get('/doctors', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'doctors'])->name('analytics.doctors');
    Route::get('/departments', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'departments'])->name('analytics.departments');
    Route::get('/pharmacy', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'pharmacy'])->name('analytics.pharmacy');
    Route::get('/laboratory', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'laboratory'])->name('analytics.laboratory');
    Route::get('/inventory', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'inventory'])->name('analytics.inventory');
    Route::get('/hr', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'hr'])->name('analytics.hr');
    Route::get('/appointments', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'appointments'])->name('analytics.appointments');
    Route::get('/finance', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'finance'])->name('analytics.finance');
    Route::get('/forecast', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'forecast'])->name('analytics.forecast');
    Route::get('/audit', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'audit'])->name('analytics.audit');
    Route::get('/reports', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'reports'])->name('analytics.reports');
    Route::get('/settings', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'settings'])->name('analytics.settings');
    
    // Custom Dashboard configuration actions
    Route::post('/widgets/update', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'updateWidgets'])->name('analytics.widgets.update');
    Route::post('/filters/save', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'saveFilter'])->name('analytics.filters.save');
    Route::post('/reports/schedule', [\App\Http\Controllers\Analytics\ExecutiveDashboardController::class, 'scheduleReport'])->name('analytics.reports.schedule');
});

// CMS & Marketing Automation Routes
Route::prefix('cms')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Cms\CmsDashboardController::class, 'index'])->name('cms.dashboard');
    Route::get('/pages', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'pages'])->name('cms.pages');
    Route::get('/builder/{id}', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'builder'])->name('cms.builder');
    Route::post('/builder/{id}', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'updateBlocks'])->name('cms.builder.update');
    
    Route::get('/blog', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'blog'])->name('cms.blog');
    Route::get('/news', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'news'])->name('cms.news');
    Route::get('/events', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'events'])->name('cms.events');
    Route::get('/careers', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'careers'])->name('cms.careers');
    Route::get('/testimonials', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'testimonials'])->name('cms.testimonials');
    Route::get('/faqs', [\App\Http\Controllers\Cms\CmsPageBuilderController::class, 'faqs'])->name('cms.faqs');
    
    Route::get('/newsletter', [\App\Http\Controllers\Cms\MarketingController::class, 'newsletter'])->name('cms.newsletter');
    Route::get('/campaigns', [\App\Http\Controllers\Cms\MarketingController::class, 'campaigns'])->name('cms.campaigns');
    Route::post('/campaigns', [\App\Http\Controllers\Cms\MarketingController::class, 'storeCampaign'])->name('cms.campaigns.store');
    Route::get('/contact', [\App\Http\Controllers\Cms\MarketingController::class, 'contactMessages'])->name('cms.contact');
    
    Route::get('/seo', [\App\Http\Controllers\Cms\SeoController::class, 'seo'])->name('cms.seo');
    Route::post('/seo/redirect', [\App\Http\Controllers\Cms\SeoController::class, 'storeRedirect'])->name('cms.seo.redirect');
    Route::get('/settings', [\App\Http\Controllers\Cms\SeoController::class, 'settings'])->name('cms.settings');
    Route::post('/settings', [\App\Http\Controllers\Cms\SeoController::class, 'updateSettings'])->name('cms.settings.update');
});

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $db = 'connected';
    } catch (\Exception $e) {
        $db = 'error: ' . $e->getMessage();
    }
    
    try {
        Illuminate\Support\Facades\Redis::connect('redis', 6379);
        $redis = 'connected';
    } catch (\Exception $e) {
        $redis = 'disconnected';
    }

    return response()->json([
        'status' => 'healthy',
        'database' => $db,
        'redis' => $redis,
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/{page}', [PublicPageController::class, 'page'])
    ->whereIn('page', config('AarogyaCare.public_pages'))
    ->name('public.page');
