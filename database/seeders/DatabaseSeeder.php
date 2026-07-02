<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\MedicalReport;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect(config('AarogyaCare.roles'))->map(function (array $role, string $slug): Role {
            return Role::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $role['name'],
                    'dashboard_path' => route('dashboard.role', ['role' => $slug], false),
                    'permissions' => $role['nav'],
                ]
            );
        });

        $departments = collect([
            'Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Oncology',
            'Radiology', 'Emergency', 'Dermatology', 'ENT', 'Gynecology',
            'Urology', 'Gastroenterology', 'Pulmonology', 'Psychiatry', 'ICU',
        ])->map(fn (string $name): Department => Department::query()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => "Advanced $name care with coordinated diagnostics, treatment planning, and outcome monitoring.",
            'icon' => 'fa-stethoscope',
        ]));

        $adminRole = $roles['hospital-admin'];
        User::query()->updateOrCreate(
            ['email' => 'admin@AarogyaCare.test'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Aarav Mehta',
                'password' => Hash::make('password'),
                'phone' => '+91 90000 00001',
                'status' => 'active',
            ]
        );

        $receptionistRole = $roles['receptionist'];
        User::query()->updateOrCreate(
            ['email' => 'receptionist@AarogyaCare.test'],
            [
                'role_id' => $receptionistRole->id,
                'name' => 'Sara Khan',
                'password' => Hash::make('password'),
                'phone' => '+91 90000 00002',
                'status' => 'active',
            ]
        );

        $doctorRole = $roles['doctor'];
        $doctorImages = [
            'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=400&q=80',
            'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=400&q=80',
        ];

        $doctors = collect(range(1, 30))->map(function (int $index) use ($doctorRole, $departments, $doctorImages): Doctor {
            $department = $departments->random();
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $fullName = "Dr. {$firstName} {$lastName}";
            $email = "doctor$index@aarogyacare.test";

            $user = User::query()->create([
                'role_id' => $doctorRole->id,
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'avatar_url' => $doctorImages[$index % count($doctorImages)],
            ]);

            $doc = Doctor::query()->create([
                'user_id' => $user->id,
                'employee_id' => 'EMP-' . str_pad((string)$index, 4, '0', STR_PAD_LEFT),
                'doctor_code' => 'DOC-' . str_pad((string)$index, 4, '0', STR_PAD_LEFT),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'full_name' => $fullName,
                'slug' => Str::slug($fullName),
                'gender' => fake()->randomElement(['Male', 'Female']),
                'photo' => $user->avatar_url,
                'cover_photo' => 'public/images/hospital.png',
                'email' => $email,
                'phone' => $user->phone,
                'department_id' => $department->id,
                'specialization' => $department->name . ' Specialist',
                'qualification' => fake()->randomElement(['MBBS, MD', 'MBBS, MS', 'MBBS, MD, DM', 'MBBS, DNB']),
                'education' => 'AIMS Delhi, Fellow in ' . $department->name,
                'experience_years' => fake()->numberBetween(5, 30),
                'registration_number' => 'REG-' . str_pad((string)$index, 6, '0', STR_PAD_LEFT),
                'consultation_fee' => fake()->randomFloat(2, 400, 1500),
                'online_fee' => fake()->randomFloat(2, 300, 1200),
                'languages' => ['English', 'Hindi', 'Tamil'],
                'bio' => 'Dedicated senior clinical specialist committed to delivering exceptional patient care pathways.',
                'expertise' => ['Minimally Invasive Surgery', 'Diagnostics', 'Clinical Research'],
                'awards' => ['Healthcare Excellence Award 2023', 'Best Clinical Researcher 2024'],
                'certifications' => ['Board Certified Specialist', 'Advanced Critical Care Support'],
                'publications' => ['Global Medical Journal - Clinical Outcomes 2025'],
                'hospital' => 'AarogyaCare, Bengaluru',
                'working_days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                'working_hours' => '09:00 AM - 05:00 PM',
                'available_today' => true,
                'video_consultation' => true,
                'rating' => fake()->randomFloat(1, 4.5, 5.0),
                'review_count' => 15,
                'patients_treated' => fake()->numberBetween(100, 5000),
                'surgeries_completed' => fake()->numberBetween(10, 800),
                'status' => 'active',
                'facebook' => 'https://facebook.com',
                'linkedin' => 'https://linkedin.com',
                'instagram' => 'https://instagram.com',
                'twitter' => 'https://twitter.com',
                'meta_title' => "{$fullName} | AarogyaCare",
                'meta_description' => "Consult {$fullName}, {$department->name} specialist at AarogyaCare.",
            ]);

            // Seed 2 patient reviews for each doctor (total 60 reviews)
            collect(range(1, 2))->each(fn() => \App\Models\DoctorReview::query()->create([
                'doctor_id' => $doc->id,
                'patient_name' => fake()->name(),
                'patient_photo' => null,
                'rating' => fake()->numberBetween(4, 5),
                'review' => fake()->sentence(15),
                'is_verified' => true,
            ]));

            return $doc;
        });

        $patientRole = $roles['patient'];
        $patients = collect(range(1, 100))->map(function (int $index) use ($patientRole): Patient {
            $user = User::query()->create([
                'role_id' => $patientRole->id,
                'name' => fake()->name(),
                'email' => "patient$index@AarogyaCare.test",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
            ]);

            return Patient::query()->create([
                'user_id' => $user->id,
                'patient_code' => 'PAT-'.str_pad((string) $index, 6, '0', STR_PAD_LEFT),
                'date_of_birth' => fake()->dateTimeBetween('-82 years', '-1 year'),
                'gender' => fake()->randomElement(['female', 'male', 'non-binary']),
                'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
                'emergency_contact' => fake()->phoneNumber(),
                'insurance_provider' => fake()->randomElement(['CareShield', 'Aetna Global', 'Bajaj Health', 'Star Health', null]),
                'medical_alerts' => fake()->randomElements(['Diabetes', 'Hypertension', 'Penicillin allergy', 'Asthma'], fake()->numberBetween(0, 2)),
            ]);
        });

        collect(range(1, 500))->each(function () use ($patients, $doctors): void {
            $doctor = $doctors->random();
            Appointment::query()->create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctor->id,
                'department_id' => $doctor->department_id,
                'appointment_at' => fake()->dateTimeBetween('-30 days', '+45 days'),
                'type' => fake()->randomElement(['in-person', 'video', 'emergency']),
                'status' => fake()->randomElement(['scheduled', 'checked-in', 'completed', 'cancelled']),
                'reason' => fake()->sentence(12),
                'triage_score' => fake()->numberBetween(1, 10),
            ]);
        });

        collect(range(1, 1000))->each(fn (): MedicalReport => MedicalReport::query()->create([
            'patient_id' => $patients->random()->id,
            'doctor_id' => $doctors->random()->id,
            'title' => fake()->randomElement(['CBC Panel', 'MRI Review', 'Cardiac Risk Assessment', 'Discharge Summary']),
            'report_type' => fake()->randomElement(['lab', 'radiology', 'clinical', 'discharge']),
            'summary' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'final', 'review']),
            'reported_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]));

        collect(range(1, 500))->each(fn (int $index): Bill => Bill::query()->create([
            'patient_id' => $patients->random()->id,
            'invoice_number' => 'INV-'.str_pad((string) $index, 7, '0', STR_PAD_LEFT),
            'amount' => fake()->randomFloat(2, 80, 8000),
            'tax' => fake()->randomFloat(2, 4, 450),
            'discount' => fake()->randomFloat(2, 0, 300),
            'status' => fake()->randomElement(['paid', 'pending', 'overdue', 'insurance-review']),
            'due_at' => fake()->dateTimeBetween('-60 days', '+30 days'),
        ]));

        collect(range(1, 200))->each(fn (int $index): Medicine => Medicine::query()->create([
            'name' => fake()->randomElement(['Amoxicillin', 'Atorvastatin', 'Metformin', 'Salbutamol', 'Paracetamol'])." $index",
            'sku' => 'MED-'.str_pad((string) $index, 6, '0', STR_PAD_LEFT),
            'category' => fake()->randomElement(['Antibiotic', 'Cardiac', 'Diabetes', 'Respiratory', 'Pain Relief']),
            'stock' => fake()->numberBetween(5, 900),
            'reorder_level' => fake()->numberBetween(20, 120),
            'unit_price' => fake()->randomFloat(2, 1, 120),
            'expires_at' => fake()->dateTimeBetween('+2 months', '+3 years'),
        ]));

        collect(range(1, 300))->each(fn (): Prescription => Prescription::query()->create([
            'patient_id' => $patients->random()->id,
            'doctor_id' => $doctors->random()->id,
            'appointment_id' => fake()->boolean(80) ? Appointment::query()->inRandomOrder()->first()?->id : null,
            'medication_name' => fake()->randomElement(['Amoxicillin', 'Atorvastatin', 'Metformin', 'Salbutamol', 'Paracetamol', 'Ibuprofen', 'Lisinopril', 'Levothyroxine', 'Gabapentin', 'Alprazolam']),
            'dosage' => fake()->randomElement(['250mg', '500mg', '10mg', '20mg', '100mg', '1 puff', '1 tablet']),
            'frequency' => fake()->randomElement(['Once daily', 'Twice a day', 'Three times daily', 'Every 8 hours', 'As needed for pain']),
            'duration' => fake()->randomElement(['5 days', '7 days', '10 days', '14 days', '30 days', '3 months']),
            'instructions' => fake()->randomElement(['Take after meals with water', 'Take on an empty stomach', 'Avoid dairy products', 'May cause drowsiness', 'Keep hydrated']),
            'issued_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]));

        $this->call(ServiceSeeder::class);
        $this->call(AiModuleSeeder::class);
        $this->call(AnalyticsModuleSeeder::class);
        $this->call(CmsModuleSeeder::class);
    }
}
