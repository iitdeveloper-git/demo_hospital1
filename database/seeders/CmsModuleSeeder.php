<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsBlock;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NewsArticle;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\CareerJob;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CmsModuleSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        // 1. Seed Website Settings
        $settings = [
            ['key' => 'hospital_logo', 'value' => '/images/logo.png'],
            ['key' => 'favicon', 'value' => '/images/favicon.ico'],
            ['key' => 'business_hours', 'value' => '24/7 Emergency, Mon-Sat OPD: 09:00 AM - 08:00 PM'],
            ['key' => 'social_links', 'value' => json_encode(['fb' => '#', 'tw' => '#', 'li' => '#'])],
        ];
        foreach ($settings as $set) {
            WebsiteSetting::query()->updateOrCreate(['key' => $set['key']], $set);
        }

        // 2. Seed 100 CMS Pages in bulk
        $pagesData = [];
        $sectionsData = [];
        $blocksData = [];
        
        for ($i = 1; $i <= 100; $i++) {
            $slug = "page-slug-$i";
            if ($i === 1) $slug = 'home';
            elseif ($i === 2) $slug = 'about-us';
            elseif ($i === 3) $slug = 'careers';
            
            $pageId = DB::table('cms_pages')->insertGetId([
                'title' => "Hospital Core Page #$i",
                'slug' => $slug,
                'is_published' => true,
                'published_at' => now(),
                'template' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add dynamic section and blocks for first 10 pages to show page builder grid
            if ($i <= 10) {
                $secId = DB::table('cms_sections')->insertGetId([
                    'page_id' => $pageId,
                    'section_type' => 'hero_section',
                    'order' => 1,
                    'settings_json' => json_encode(['background' => '#0b2454']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('cms_blocks')->insert([
                    'section_id' => $secId,
                    'block_type' => 'hero_banner',
                    'content_json' => json_encode(['title' => 'World Class Clinical Excellence', 'button_text' => 'Book OPD Visit']),
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3. Seed 200 Blog posts
        $cat1 = BlogCategory::create(['name' => 'Cardiac Care', 'slug' => 'cardiac-care']);
        $cat2 = BlogCategory::create(['name' => 'Neurology Insights', 'slug' => 'neurology-insights']);
        
        $blogs = [];
        for ($i = 1; $i <= 200; $i++) {
            $blogs[] = [
                'category_id' => $i % 2 === 0 ? $cat1->id : $cat2->id,
                'author_id' => $users->random()->id,
                'title' => "Clinical wellness guide and updates #$i",
                'slug' => "blog-post-slug-$i",
                'featured_image' => 'public/images/hospital.png',
                'content' => 'Comprehensive clinical analysis on disease prevention and healthy lifestyle management routines.',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        foreach (array_chunk($blogs, 50) as $chunk) {
            DB::table('blog_posts')->insert($chunk);
        }

        // 4. Seed 100 News Articles
        $news = [];
        for ($i = 1; $i <= 100; $i++) {
            $news[] = [
                'title' => "Hospital Press Release Announcement #$i",
                'slug' => "news-slug-$i",
                'content' => 'Official announcement regarding the launch of advanced diagnostic scanners and new OPD wings.',
                'category' => 'press',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        foreach (array_chunk($news, 50) as $chunk) {
            DB::table('news_articles')->insert($chunk);
        }

        // 5. Seed 50 Events
        $events = [];
        for ($i = 1; $i <= 50; $i++) {
            $events[] = [
                'title' => "Free Blood Donation & Triage Camp #$i",
                'description' => 'Participate in our monthly wellness checkup camp and blood collection drive organized by general medicine.',
                'location' => 'Block A Auditory Hall',
                'start_at' => now()->addDays($i),
                'end_at' => now()->addDays($i)->addHours(4),
                'status' => 'upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('events')->insert($events);

        // 6. Testimonials & FAQs (100 each)
        $testimonials = [];
        for ($i = 1; $i <= 100; $i++) {
            $testimonials[] = [
                'name' => "Patient Witness #$i",
                'role' => 'Cardiology Patient',
                'photo' => null,
                'content' => 'Excellent outpatient triage service and compassionate medical specialists who monitored my recovery timelines.',
                'rating' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('testimonials')->insert($testimonials);

        $faqs = [];
        for ($i = 1; $i <= 100; $i++) {
            $faqs[] = [
                'question' => "What is the emergency triage wait time? (#$i)",
                'answer' => 'Patients are evaluated instantly upon arrival by clinical paramedics to determine urgency.',
                'category' => 'triage',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('faqs')->insert($faqs);

        // 7. Career Jobs (50)
        $jobs = [];
        $titles = ['Senior Critical Care Nurse', 'OPD General Practitioner', 'LIMS Lab Executive', 'Pharmacy Registrar'];
        for ($i = 1; $i <= 50; $i++) {
            $jobs[] = [
                'title' => $titles[$i % count($titles)] . " #$i",
                'department' => 'Clinical Medicine',
                'location' => 'On-site (Bengaluru HQ)',
                'description' => 'Requires board credentials and 3+ years experience in multi-specialty trauma centers.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('career_jobs')->insert($jobs);
    }
}
