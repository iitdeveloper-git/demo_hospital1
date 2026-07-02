<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('short_description');
            $table->longText('full_description');
            $table->string('icon')->default('fa-stethoscope');
            $table->string('featured_image');
            $table->string('banner_image');
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_from', 10, 2);
            $table->string('duration');
            $table->json('benefits')->nullable();
            $table->json('preparation')->nullable();
            $table->json('procedure')->nullable();
            $table->string('recovery_time')->nullable();
            $table->json('faq')->nullable();
            $table->string('status')->default('active')->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
