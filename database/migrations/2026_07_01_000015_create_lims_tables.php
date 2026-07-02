<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lab_test_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('lab_tests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained('lab_test_categories')->cascadeOnDelete();
            $table->string('test_code')->unique()->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('normal_range')->nullable();
            $table->string('units')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });

        Schema::create('lab_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number')->unique()->index();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('priority')->default('normal')->index();
            $table->string('status')->default('pending')->index();
            $table->timestamp('collection_date')->nullable();
            $table->timestamps();
        });

        Schema::create('sample_collections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('lab_order_id')->constrained('lab_orders')->cascadeOnDelete();
            $table->string('sample_id')->unique()->index();
            $table->string('sample_type')->index(); // blood, urine, saliva, stool, tissue
            $table->timestamp('collection_date')->useCurrent();
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('status')->default('collected')->index(); // collected, received, processing, completed
            $table->timestamps();
        });

        Schema::create('lab_equipments', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->index();
            $table->string('type')->index();
            $table->timestamp('maintenance_date')->nullable();
            $table->string('status')->default('operational')->index();
            $table->timestamps();
        });

        Schema::create('reagents', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->index();
            $table->string('batch_number')->unique();
            $table->timestamp('expiry_date')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('low_stock_level')->default(10);
            $table->timestamps();
        });

        Schema::create('quality_control_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('equipment_id')->constrained('lab_equipments')->cascadeOnDelete();
            $table->string('qc_name')->index();
            $table->string('result')->index();
            $table->string('status')->default('approved')->index();
            $table->timestamp('checked_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_control_logs');
        Schema::dropIfExists('reagents');
        Schema::dropIfExists('lab_equipments');
        Schema::dropIfExists('sample_collections');
        Schema::dropIfExists('lab_orders');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('lab_test_categories');
    }
};
