<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop existing medicines table to avoid conflicts with LIMS/ERP columns
        Schema::dropIfExists('medicines');

        Schema::create('medicine_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('medicine_brands', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table): void {
            $table->id();
            $table->string('supplier_code')->unique()->index();
            $table->string('company_name')->index();
            $table->string('gst_number')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->decimal('outstanding_balance', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table): void {
            $table->id();
            $table->string('medicine_code')->unique()->index();
            $table->string('barcode')->unique()->index();
            $table->string('name')->index();
            $table->string('generic_name')->nullable()->index();
            $table->foreignId('brand_id')->nullable()->constrained('medicine_brands')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('medicine_categories')->nullOnDelete();
            $table->string('strength')->nullable();
            $table->string('dosage_form')->nullable(); // tablet, syrup, injection
            $table->string('pack_size')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('reorder_level')->default(20);
            $table->string('manufacturer')->nullable();
            $table->string('status')->default('active')->index();
            $table->date('expires_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('po_number')->unique()->index();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('status')->default('pending')->index(); // pending, partially-received, completed
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();
            $table->string('batch_number')->index();
            $table->date('expiry_date')->nullable();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('sales_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('invoice_number')->unique()->index();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('payment_method')->default('cash')->index();
            $table->string('status')->default('paid')->index();
            $table->timestamps();
        });

        Schema::create('sales_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('medicine_returns', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->foreignId('medicine_id')->constrained('medicines')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('type')->default('customer')->index(); // customer, supplier
            $table->text('reason')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_returns');
        Schema::dropIfExists('sales_items');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('medicine_brands');
        Schema::dropIfExists('medicine_categories');
    }
};
