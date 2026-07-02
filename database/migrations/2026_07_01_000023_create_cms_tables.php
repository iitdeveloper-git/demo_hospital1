<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->string('template')->default('default');
            $table->timestamps();
        });

        Schema::create('cms_sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('page_id')->constrained('cms_pages')->cascadeOnDelete();
            $table->string('section_type')->index();
            $table->integer('order')->default(0);
            $table->json('settings_json')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_blocks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('section_id')->constrained('cms_sections')->cascadeOnDelete();
            $table->string('block_type')->index();
            $table->json('content_json')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('cms_menus', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('location_key')->unique()->index();
            $table->timestamps();
        });

        Schema::create('cms_menu_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('menu_id')->constrained('cms_menus')->cascadeOnDelete();
            $table->string('label');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('media_library', function (Blueprint $table): void {
            $table->id();
            $table->string('filename');
            $table->string('path')->unique();
            $table->string('file_type')->index();
            $table->integer('size_bytes');
            $table->string('folder')->default('root')->index();
            $table->json('tags_json')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained('blog_categories')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->string('featured_image')->nullable();
            $table->text('content');
            $table->string('status')->default('draft')->index(); // draft, published, scheduled
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_tags', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->timestamps();
        });

        Schema::create('news_articles', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('content');
            $table->string('category')->default('hospital')->index(); // press, announcement, hospital
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->timestamp('start_at')->nullable()->index();
            $table->timestamp('end_at')->nullable();
            $table->string('status')->default('upcoming')->index(); // upcoming, active, completed, cancelled
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('photo')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table): void {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->string('category')->default('general')->index();
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('career_jobs', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('department')->index();
            $table->string('location')->default('On-site');
            $table->text('description');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('career_applications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('job_id')->constrained('career_jobs')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('resume_path');
            $table->string('status')->default('applied')->index(); // applied, reviewing, interviewed, hired, rejected
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('unread')->index(); // unread, read, replied
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique()->index();
            $table->boolean('is_verified')->default(false)->index();
            $table->string('token')->nullable();
            $table->timestamps();
        });

        Schema::create('marketing_campaigns', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('channel')->index(); // email, sms, whatsapp, push
            $table->string('status')->default('draft')->index(); // draft, scheduled, sent
            $table->timestamp('schedule_at')->nullable();
            $table->text('template_content')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_metadata', function (Blueprint $table): void {
            $table->id();
            $table->string('model_type')->nullable()->index();
            $table->unsignedBigInteger('model_id')->nullable()->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->json('schema_json')->nullable();
            $table->timestamps();
        });

        Schema::create('redirect_rules', function (Blueprint $table): void {
            $table->id();
            $table->string('old_slug')->unique()->index();
            $table->string('new_slug')->index();
            $table->unsignedSmallInteger('status_code')->default(301); // 301 or 302
            $table->timestamps();
        });

        Schema::create('website_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('redirect_rules');
        Schema::dropIfExists('seo_metadata');
        Schema::dropIfExists('marketing_campaigns');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('career_applications');
        Schema::dropIfExists('career_jobs');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('events');
        Schema::dropIfExists('news_articles');
        Schema::dropIfExists('blog_tags');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('media_library');
        Schema::dropIfExists('cms_menu_items');
        Schema::dropIfExists('cms_menus');
        Schema::dropIfExists('cms_blocks');
        Schema::dropIfExists('cms_sections');
        Schema::dropIfExists('cms_pages');
    }
};
