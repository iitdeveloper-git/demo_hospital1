<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('blood_pressure')->nullable(); // e.g. "120/80"
            $table->unsignedInteger('heart_rate')->nullable(); // e.g. 72
            $table->decimal('temperature', 4, 1)->nullable(); // e.g. 98.6
            $table->unsignedInteger('oxygen_level')->nullable(); // e.g. 98
            $table->unsignedInteger('blood_sugar')->nullable(); // e.g. 110
            $table->decimal('weight', 5, 2)->nullable(); // e.g. 70.5
            $table->decimal('height', 5, 2)->nullable(); // e.g. 175.0
            $table->decimal('bmi', 4, 2)->nullable(); // e.g. 23.01
            $table->text('medical_notes')->nullable();
            $table->dateTime('recorded_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
