<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'short_description' => $this->faker->paragraph(2),
            'full_description' => $this->faker->paragraphs(5, true),
            'icon' => $this->faker->randomElement(['fa-heart-pulse', 'fa-brain', 'fa-bone', 'fa-tooth', 'fa-ear-listen', 'fa-x-ray', 'fa-bed-pulse', 'fa-kit-medical']),
            'featured_image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=600&q=80',
            'banner_image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1200&q=80',
            'department_id' => Department::factory(),
            'price_from' => $this->faker->randomFloat(2, 50, 1500),
            'duration' => $this->faker->randomElement(['30 Mins', '1 Hour', '2 Hours', '1-2 Days']),
            'benefits' => [
                'Faster recovery times',
                'Advanced clinical precision',
                'Comprehensive post-procedure guidance',
            ],
            'preparation' => [
                'Fast for 8 hours prior',
                'Avoid strenuous activity 24 hours before',
                'Bring previous medical records',
            ],
            'procedure' => [
                'Step 1: Patient registration and assessment',
                'Step 2: Administration of preparatory treatment',
                'Step 3: Execution of the clinical protocol',
            ],
            'recovery_time' => '1-3 Days',
            'faq' => [
                ['question' => 'Is this procedure painful?', 'answer' => 'We utilize advanced anesthetics to ensure minimal discomfort.'],
                ['question' => 'When will I get my reports?', 'answer' => 'Reports are usually uploaded to your patient portal within 24 hours.'],
            ],
            'status' => 'active',
            'meta_title' => "$title | AarogyaCare",
            'meta_description' => $this->faker->sentence(12),
        ];
    }
}
