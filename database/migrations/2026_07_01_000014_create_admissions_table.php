<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('ward_type')->index(); // general, private, semi-private, icu, nicu, emergency
            $table->string('bed_number')->index();
            $table->timestamp('admission_date')->useCurrent();
            $table->timestamp('expected_discharge')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('admitted')->index(); // admitted, discharged
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
