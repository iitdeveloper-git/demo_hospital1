<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->default('fa-stethoscope');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('employee_id')->unique()->index();
            $table->string('doctor_code')->unique()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->index();
            $table->string('slug')->unique()->index();
            $table->string('gender', 24)->index();
            $table->string('photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->string('specialization')->index();
            $table->string('qualification');
            $table->text('education')->nullable();
            $table->unsignedTinyInteger('experience_years')->default(5);
            $table->string('registration_number')->unique();
            $table->decimal('consultation_fee', 10, 2);
            $table->decimal('online_fee', 10, 2)->default(0);
            $table->json('languages')->nullable();
            $table->text('bio')->nullable();
            $table->json('expertise')->nullable();
            $table->json('awards')->nullable();
            $table->json('certifications')->nullable();
            $table->json('publications')->nullable();
            $table->string('hospital')->default('AarogyaCare');
            $table->json('working_days')->nullable();
            $table->string('working_hours')->default('09:00 AM - 05:00 PM');
            $table->boolean('available_today')->default(true)->index();
            $table->boolean('video_consultation')->default(true)->index();
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->unsignedInteger('review_count')->default(0);
            $table->unsignedInteger('patients_treated')->default(0);
            $table->unsignedInteger('surgeries_completed')->default(0);
            $table->string('status')->default('active')->index();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('patient_code')->unique();
            $table->date('date_of_birth')->index();
            $table->string('gender', 24)->index();
            $table->string('blood_group', 8)->nullable()->index();
            $table->string('emergency_contact');
            $table->string('insurance_provider')->nullable();
            $table->json('medical_alerts')->nullable();
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->dateTime('appointment_at')->index();
            $table->string('type')->default('in-person')->index();
            $table->string('status')->default('scheduled')->index();
            $table->text('reason');
            $table->unsignedTinyInteger('triage_score')->default(3)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('departments');
    }
};
