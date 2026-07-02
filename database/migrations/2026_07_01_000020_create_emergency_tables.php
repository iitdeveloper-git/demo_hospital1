<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ambulances', function (Blueprint $table): void {
            $table->id();
            $table->string('vehicle_number')->unique()->index();
            $table->string('vehicle_type')->default('BLS')->index(); // BLS, ALS
            $table->boolean('availability')->default(true)->index();
            $table->string('status')->default('operational')->index(); // operational, out-of-service
            $table->timestamps();
        });

        Schema::create('emergency_cases', function (Blueprint $table): void {
            $table->id();
            $table->string('case_number')->unique()->index();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('arrival_method')->default('walk-in')->index(); // walk-in, ambulance
            $table->string('priority_level')->default('yellow')->index(); // red, orange, yellow, green, black
            $table->string('status')->default('triage')->index(); // triage, icu, ot, discharged
            $table->timestamps();
        });

        Schema::create('triage_assessments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('emergency_case_id')->constrained('emergency_cases')->cascadeOnDelete();
            $table->integer('heart_rate')->nullable();
            $table->string('blood_pressure', 24)->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('oxygen_saturation')->nullable();
            $table->integer('pain_scale')->nullable();
            $table->string('status')->default('yellow')->index(); // red, orange, yellow, green, black
            $table->timestamps();
        });

        Schema::create('icu_patients', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('emergency_case_id')->constrained('emergency_cases')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained('hospital_beds')->cascadeOnDelete();
            $table->string('status')->default('critical')->index(); // critical, stable
            $table->timestamps();
        });

        Schema::create('ot_bookings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('emergency_case_id')->constrained('emergency_cases')->cascadeOnDelete();
            $table->foreignId('surgeon_id')->constrained('doctors')->cascadeOnDelete();
            $table->string('ot_number')->index();
            $table->integer('estimated_duration')->default(60); // minutes
            $table->string('status')->default('scheduled')->index(); // scheduled, running, completed
            $table->timestamps();
        });

        Schema::create('emergency_alerts', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->index();
            $table->string('type')->default('Code Blue')->index(); // Code Blue, Staff Recall
            $table->string('status')->default('active')->index(); // active, resolved
            $table->timestamps();
        });

        Schema::create('disaster_mode_logs', function (Blueprint $table): void {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('staff_recalled_count')->default(0);
            $table->string('status')->default('active')->index(); // active, resolved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disaster_mode_logs');
        Schema::dropIfExists('emergency_alerts');
        Schema::dropIfExists('ot_bookings');
        Schema::dropIfExists('icu_patients');
        Schema::dropIfExists('triage_assessments');
        Schema::dropIfExists('emergency_cases');
        Schema::dropIfExists('ambulances');
    }
};
