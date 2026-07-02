<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('report_type')->index();
            $table->text('summary');
            $table->string('status')->default('final')->index();
            $table->dateTime('reported_at')->index();
            $table->timestamps();
        });

        Schema::create('bills', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('status')->default('pending')->index();
            $table->date('due_at')->index();
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category')->index();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('reorder_level')->default(20);
            $table->decimal('unit_price', 10, 2);
            $table->date('expires_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('medical_reports');
    }
};
