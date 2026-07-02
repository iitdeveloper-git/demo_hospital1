<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Models\GoodsReceipt;
use App\Models\HospitalAsset;
use App\Models\HospitalBed;
use App\Models\HospitalWard;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InvPurchaseOrder;
use App\Models\MaintenanceLog;
use App\Models\MedicalEquipment;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InventoryPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'total_items' => InventoryItem::count(),
            'low_stock' => InventoryItem::whereColumn('current_stock', '<=', 'reorder_level')->count(),
            'out_of_stock' => InventoryItem::where('current_stock', 0)->count(),
            'total_assets' => HospitalAsset::count(),
            'equipment_operational' => MedicalEquipment::where('status', 'operational')->count(),
            'beds_available' => HospitalBed::where('status', 'available')->count(),
            'beds_occupied' => HospitalBed::where('status', 'occupied')->count(),
            'active_po' => InvPurchaseOrder::where('status', 'pending')->count(),
        ];

        return view('inventory.dashboard', compact('metrics'));
    }

    public function items(Request $request): View
    {
        $query = InventoryItem::with(['category', 'warehouse']);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('item_code', 'like', '%' . $request->search . '%');
        }
        $items = $query->paginate(15);
        return view('inventory.items', compact('items'));
    }

    public function categories(): View
    {
        $categories = InventoryCategory::paginate(15);
        return view('inventory.categories', compact('categories'));
    }

    public function assets(Request $request): View
    {
        $categories = AssetCategory::all();
        $query = HospitalAsset::with(['category']);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('asset_tag', 'like', '%' . $request->search . '%');
        }
        $assets = $query->paginate(15);
        return view('inventory.assets', compact('categories', 'assets'));
    }

    public function storeAsset(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'category_id' => ['required', 'exists:asset_categories,id'],
            'current_value' => ['required', 'numeric', 'min:0'],
        ]);

        HospitalAsset::create([
            'asset_tag' => 'AST-' . strtoupper(Str::random(6)),
            'barcode' => 'BAR-' . strtoupper(Str::random(6)),
            'name' => $request->name,
            'category_id' => $request->category_id,
            'purchase_date' => now()->toDateString(),
            'current_value' => $request->current_value,
            'status' => 'active',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Hospital Asset registered successfully!',
        ]);

        return back();
    }

    public function equipment(): View
    {
        $equipment = MedicalEquipment::paginate(15);
        return view('inventory.equipment', compact('equipment'));
    }

    public function storeEquipment(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'manufacturer' => ['required', 'string'],
        ]);

        MedicalEquipment::create([
            'equipment_code' => 'EQP-' . strtoupper(Str::random(6)),
            'name' => $request->name,
            'manufacturer' => $request->manufacturer,
            'calibration_date' => now()->toDateString(),
            'status' => 'operational',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Clinical device calibration parameters logged.',
        ]);

        return back();
    }

    public function beds(): View
    {
        $beds = HospitalBed::with('ward')->paginate(20);
        return view('inventory.beds', compact('beds'));
    }

    public function wards(): View
    {
        $wards = HospitalWard::withCount('beds')->paginate(15);
        return view('inventory.wards', compact('wards'));
    }

    public function purchaseOrders(): View
    {
        $vendors = Vendor::all();
        $orders = InvPurchaseOrder::with('vendor')->orderBy('id', 'desc')->paginate(15);
        return view('inventory.purchase-orders', compact('vendors', 'orders'));
    }

    public function goodsReceipt(): View
    {
        $orders = InvPurchaseOrder::where('status', 'pending')->get();
        $receipts = GoodsReceipt::with('purchaseOrder.vendor')->orderBy('id', 'desc')->paginate(15);
        return view('inventory.goods-receipt', compact('orders', 'receipts'));
    }

    public function storeReceipt(Request $request): RedirectResponse
    {
        $request->validate([
            'purchase_order_id' => ['required', 'exists:inv_purchase_orders,id'],
        ]);

        $po = InvPurchaseOrder::findOrFail($request->purchase_order_id);
        $po->update(['status' => 'received']);

        GoodsReceipt::create([
            'purchase_order_id' => $po->id,
            'received_date' => now()->toDateString(),
            'status' => 'completed',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Goods receipt checked in and stock updated.',
        ]);

        return back();
    }

    public function transfers(): View
    {
        $warehouses = Warehouse::all();
        return view('inventory.transfers', compact('warehouses'));
    }

    public function vendors(): View
    {
        $vendors = Vendor::paginate(15);
        return view('inventory.vendors', compact('vendors'));
    }

    public function maintenance(): View
    {
        $devices = MedicalEquipment::all();
        $logs = MaintenanceLog::with('equipment')->orderBy('id', 'desc')->paginate(15);
        return view('inventory.maintenance', compact('devices', 'logs'));
    }

    public function storeMaintenance(Request $request): RedirectResponse
    {
        $request->validate([
            'equipment_id' => ['required', 'exists:medical_equipment,id'],
            'cost' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
        ]);

        MaintenanceLog::create([
            'equipment_id' => $request->equipment_id,
            'maintenance_date' => now()->toDateString(),
            'cost' => $request->cost,
            'description' => $request->description,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Preventive calibration task authorized.',
        ]);

        return back();
    }

    public function reports(): View
    {
        return view('inventory.reports');
    }

    public function settings(): View
    {
        return view('inventory.settings');
    }
}
