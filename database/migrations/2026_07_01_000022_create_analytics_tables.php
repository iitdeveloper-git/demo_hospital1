<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('analytics_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('branch_id')->nullable()->index();
            $table->date('snapshot_date')->index();
            $table->string('category')->index(); // e.g. revenue, patient, hr, lab, pharmacy
            $table->json('metrics_json');
            $table->timestamps();
        });

        Schema::create('dashboard_widgets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('widget_key')->index();
            $table->integer('width')->default(4);
            $table->integer('height')->default(3);
            $table->integer('x_pos')->default(0);
            $table->integer('y_pos')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('scheduled_reports', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('report_type'); // e.g. revenue, patient, clinical
            $table->string('frequency'); // e.g. daily, weekly, monthly
            $table->string('recipient_email');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });

        Schema::create('saved_filters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('filter_name');
            $table->string('module')->index();
            $table->json('filter_json');
            $table->timestamps();
        });

        Schema::create('kpi_targets', function (Blueprint $table): void {
            $table->id();
            $table->string('kpi_name')->index();
            $table->decimal('target_value', 14, 2);
            $table->decimal('current_value', 14, 2)->default(0.00);
            $table->decimal('achievement_percentage', 5, 2)->default(0.00);
            $table->string('category')->index(); // financial, clinical, operational
            $table->date('starts_at')->index();
            $table->date('ends_at')->index();
            $table->timestamps();
        });

        Schema::create('forecast_models', function (Blueprint $table): void {
            $table->id();
            $table->string('model_type')->index(); // revenue, patient, bed_demand
            $table->json('variables_json');
            $table->json('forecast_outputs_json');
            $table->timestamps();
        });

        Schema::create('executive_notes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('note_content');
            $table->string('category')->index();
            $table->timestamps();
        });

        Schema::create('audit_sessions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('login_at')->useCurrent();
            $table->timestamp('logout_at')->nullable();
            $table->string('session_token')->unique()->index();
            $table->timestamps();
        });

        Schema::create('audit_events', function (Blueprint $table): void {
            $table->id();
            $table->string('session_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action')->index(); // login, logout, create, read, update, delete, finance
            $table->string('affected_module')->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('browser')->nullable();
            $table->json('old_values_json')->nullable();
            $table->json('new_values_json')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('system_metrics', function (Blueprint $table): void {
            $table->id();
            $table->decimal('cpu_load', 5, 2);
            $table->decimal('memory_load', 5, 2);
            $table->integer('active_connections');
            $table->timestamp('logged_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_metrics');
        Schema::dropIfExists('audit_events');
        Schema::dropIfExists('audit_sessions');
        Schema::dropIfExists('executive_notes');
        Schema::dropIfExists('forecast_models');
        Schema::dropIfExists('kpi_targets');
        Schema::dropIfExists('saved_filters');
        Schema::dropIfExists('scheduled_reports');
        Schema::dropIfExists('dashboard_widgets');
        Schema::dropIfExists('analytics_snapshots');
    }
};
