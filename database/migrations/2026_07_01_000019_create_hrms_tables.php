<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('designations', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('salary_grade')->nullable();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table): void {
            $table->id();
            $table->string('employee_code')->unique()->index();
            $table->string('full_name')->index();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('designation_id')->constrained('designations')->cascadeOnDelete();
            $table->string('status')->default('active')->index(); // active, suspended, retired
            $table->timestamps();
        });

        Schema::create('employee_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->date('dob')->nullable();
            $table->string('gender', 24)->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('address')->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            $table->timestamps();
        });

        Schema::create('attendance_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->dateTime('check_in')->index();
            $table->dateTime('check_out')->nullable()->index();
            $table->string('status')->default('on-time')->index(); // on-time, late, half-day, absent
            $table->timestamps();
        });

        Schema::create('shift_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('shift_type')->index(); // morning, evening, night
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('leave_type')->index(); // sick, casual, earned
            $table->text('reason')->nullable();
            $table->string('status')->default('pending')->index(); // pending, approved, rejected
            $table->timestamps();
        });

        Schema::create('payrolls', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('allowances', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2);
            $table->string('status')->default('generated')->index(); // generated, paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('shift_schedules');
        Schema::dropIfExists('attendance_logs');
        Schema::dropIfExists('employee_profiles');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('designations');
    }
};
