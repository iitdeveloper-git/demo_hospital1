<?php

return [
    'public_pages' => [
        'about',
        'services',
        'health-packages',
        'departments',
        'doctors',
        'appointment',
        'gallery',
        'testimonials',
        'blog',
        'faq',
        'career',
        'contact',
        'privacy-policy',
        'terms',
    ],
    'roles' => [
        'super-admin' => [
            'name' => 'Super Admin',
            'nav' => ['Command Center', 'Hospitals', 'Subscriptions', 'Compliance', 'Analytics', 'Settings'],
        ],
        'hospital-admin' => [
            'name' => 'Hospital Admin',
            'nav' => ['Overview', 'Doctors', 'Patients', 'Reception', 'Laboratory', 'Pharmacy', 'Billing', 'Inventory', 'Employees', 'CMS', 'Reports', 'Settings'],
        ],
        'doctor' => [
            'name' => 'Doctor',
            'nav' => ['Dashboard', "Today's Patients", 'Appointments', 'Medical History', 'Prescription', 'Reports', 'Schedule', 'Video Consultation', 'Messages'],
        ],
        'receptionist' => [
            'name' => 'Reception',
            'nav' => ['Queue', 'Appointments', 'Registrations', 'Admissions', 'Discharges', 'Payments'],
        ],
        'lab-technician' => [
            'name' => 'Laboratory',
            'nav' => ['Orders', 'Samples', 'Reports', 'Machines', 'Quality Control'],
        ],
        'pharmacist' => [
            'name' => 'Pharmacy',
            'nav' => ['Prescriptions', 'Medicines', 'Dispensing', 'Purchases', 'Stock Alerts'],
        ],
        'patient' => [
            'name' => 'Patient',
            'nav' => ['Dashboard', 'Appointments', 'Medical Records', 'Lab Reports', 'Prescription', 'Bills', 'Payments', 'Insurance', 'Health Analytics', 'Profile'],
        ],
    ],
];
