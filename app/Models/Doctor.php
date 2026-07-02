<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'doctor_code',
        'first_name',
        'last_name',
        'full_name',
        'slug',
        'gender',
        'photo',
        'cover_photo',
        'email',
        'phone',
        'department_id',
        'specialization',
        'qualification',
        'education',
        'experience_years',
        'registration_number',
        'consultation_fee',
        'online_fee',
        'languages',
        'bio',
        'expertise',
        'awards',
        'certifications',
        'publications',
        'hospital',
        'working_days',
        'working_hours',
        'available_today',
        'video_consultation',
        'rating',
        'review_count',
        'patients_treated',
        'surgeries_completed',
        'status',
        'facebook',
        'linkedin',
        'instagram',
        'twitter',
        'youtube',
        'website',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'consultation_fee' => 'decimal:2',
            'online_fee' => 'decimal:2',
            'rating' => 'decimal:1',
            'review_count' => 'integer',
            'patients_treated' => 'integer',
            'surgeries_completed' => 'integer',
            'available_today' => 'boolean',
            'video_consultation' => 'boolean',
            'languages' => 'array',
            'expertise' => 'array',
            'awards' => 'array',
            'certifications' => 'array',
            'publications' => 'array',
            'working_days' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DoctorReview::class);
    }
}
