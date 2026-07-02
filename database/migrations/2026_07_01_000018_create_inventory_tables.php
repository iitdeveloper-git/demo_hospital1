<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_branches', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('code')->unique()->index();
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->index();
            $table->foreignId('branch_id')->constrained('hospital_branches')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table): void {
            $table->id();
            $table->string('item_code')->unique()->index();
            $table->string('barcode')->unique()->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('inventory_categories')->cascadeOnDelete();
            $table->decimal('purchase_price', 10, 2);
            $table->integer('current_stock')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('asset_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('hospital_assets', function (Blueprint $table): void {
            $table->id();
            $table->string('asset_tag')->unique()->index();
            $table->string('barcode')->unique()->index();
            $table->string('name')->index();
            $table->foreignId('category_id')->constrained('asset_categories')->cascadeOnDelete();
            $table->date('purchase_date')->nullable();
            $table->decimal('current_value', 12, 2);
            $table->string('status')->default('active')->index(); // active, decommissioned, in-repair
            $table->timestamps();
        });

        Schema::create('medical_equipment', function (Blueprint $table): void {
            $table->id();
            $table->string('equipment_code')->unique()->index();
            $table->string('name')->index();
            $table->string('manufacturer')->nullable()->index();
            $table->date('calibration_date')->nullable();
            $table->string('status')->default('operational')->index(); // operational, calibration-due, out-of-service
            $table->timestamps();
        });

        Schema::create('vendors', function (Blueprint $table): void {
            $table->id();
            $table->string('company_name')->unique()->index();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('inv_purchase_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('po_number')->unique()->index();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('status')->default('pending')->index(); // pending, received, cancelled
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('inv_purchase_order_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('inv_purchase_orders')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('goods_receipts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('inv_purchase_orders')->cascadeOnDelete();
            $table->date('received_date')->nullable();
            $table->string('status')->default('completed')->index();
            $table->timestamps();
        });

        Schema::create('purchase_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('item_id')->constrained('inventory_items')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('status')->default('pending')->index(); // pending, approved, rejected
            $table->timestamps();
        });

        Schema::create('hospital_wards', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('department_name')->index();
            $table->integer('capacity')->default(10);
            $table->timestamps();
        });

        Schema::create('hospital_beds', function (Blueprint $table): void {
            $table->id();
            $table->string('bed_number')->unique()->index();
            $table->foreignId('ward_id')->constrained('hospital_wards')->cascadeOnDelete();
            $table->string('status')->default('available')->index(); // available, occupied, reserved, cleaning, maintenance
            $table->timestamps();
        });

        Schema::create('maintenance_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('equipment_id')->constrained('medical_equipment')->cascadeOnDelete();
            $table->date('maintenance_date')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
        Schema::dropIfExists('hospital_beds');
        Schema::dropIfExists('hospital_wards');
        Schema::dropIfExists('purchase_requests');
        Schema::dropIfExists('goods_receipts');
        Schema::dropIfExists('inv_purchase_order_items');
        Schema::dropIfExists('inv_purchase_orders');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('medical_equipment');
        Schema::dropIfExists('hospital_assets');
        Schema::dropIfExists('asset_categories');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('hospital_branches');
        Schema::dropIfExists('inventory_categories');
    }
};
