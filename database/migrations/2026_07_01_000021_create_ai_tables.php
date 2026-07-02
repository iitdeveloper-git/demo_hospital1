<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_provider_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('provider')->unique(); // e.g. openai, azure, gemini, anthropic, ollama, lm-studio
            $table->string('model');
            $table->decimal('temperature', 3, 2)->default(0.7);
            $table->integer('token_limit')->default(2048);
            $table->text('system_prompt')->nullable();
            $table->integer('rate_limit')->default(60); // requests per min
            $table->string('fallback_strategy')->default('mock'); // e.g. mock, local
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_conversations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('role')->index(); // patient, doctor, pharmacist, etc.
            $table->boolean('is_pinned')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_messages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->string('sender_role')->index(); // user, ai
            $table->text('message_content');
            $table->string('file_path')->nullable();
            $table->integer('token_count')->default(0);
            $table->integer('latency_ms')->default(0);
            $table->timestamps();
        });

        Schema::create('ai_prompt_templates', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('version')->default('1.0.0');
            $table->text('system_prompt');
            $table->text('user_prompt_template');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_usage_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider');
            $table->string('model');
            $table->integer('prompt_tokens')->default(0);
            $table->integer('completion_tokens')->default(0);
            $table->integer('latency_ms')->default(0);
            $table->decimal('cost', 10, 6)->default(0.000000);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        Schema::create('clinical_alerts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('alert_type')->index(); // critical_lab, bp, oxygen, drug_interaction, allergy, etc.
            $table->string('severity')->default('warning')->index(); // info, warning, critical
            $table->text('message');
            $table->boolean('is_resolved')->default(false)->index();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('drug_interaction_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->string('drug_a');
            $table->string('drug_b');
            $table->string('severity')->default('moderate')->index(); // minor, moderate, major
            $table->text('interaction_description');
            $table->timestamps();
        });

        Schema::create('patient_risk_scores', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('risk_type')->index(); // diabetes, hypertension, heart, kidney, stroke, fall, bmi, readmission
            $table->decimal('score', 5, 2);
            $table->string('trend_direction')->default('stable')->index(); // up, down, stable
            $table->date('assessment_date')->index();
            $table->timestamps();
        });

        Schema::create('symptom_assessments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->text('symptoms');
            $table->integer('duration_days');
            $table->string('severity'); // low, medium, high
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->text('medical_history')->nullable();
            $table->json('possible_conditions')->nullable();
            $table->string('urgency_level')->default('routine'); // routine, urgent, emergency
            $table->string('suggested_department')->nullable();
            $table->string('suggested_specialist')->nullable();
            $table->timestamps();
        });

        Schema::create('lab_ai_analysis', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('medical_report_id')->constrained('medical_reports')->cascadeOnDelete();
            $table->json('abnormal_values')->nullable();
            $table->text('trend_analysis')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamps();
        });

        Schema::create('radiology_ai_analysis', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('medical_report_id')->constrained('medical_reports')->cascadeOnDelete();
            $table->string('status')->default('completed'); // pending, completed
            $table->text('findings_placeholder')->nullable();
            $table->text('recommended_followup')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_feedback', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('ai_message_id')->constrained('ai_messages')->cascadeOnDelete();
            $table->integer('rating')->default(0); // 1 = helpful, -1 = unhelpful
            $table->text('comments')->nullable();
            $table->foreignId('corrected_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_feedback');
        Schema::dropIfExists('radiology_ai_analysis');
        Schema::dropIfExists('lab_ai_analysis');
        Schema::dropIfExists('symptom_assessments');
        Schema::dropIfExists('patient_risk_scores');
        Schema::dropIfExists('drug_interaction_logs');
        Schema::dropIfExists('clinical_alerts');
        Schema::dropIfExists('ai_usage_logs');
        Schema::dropIfExists('ai_prompt_templates');
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('ai_provider_settings');
    }
};
