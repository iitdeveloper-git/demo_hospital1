<?php

return [
    'headers' => [
        'x_frame_options' => 'SAMEORIGIN',
        'x_content_type_options' => 'nosniff',
        'referrer_policy' => 'strict-origin-when-cross-origin',
    ],
    'rate_limits' => [
        'appointment_requests_per_minute' => 6,
        'login_attempts_per_minute' => 5,
    ],
];
