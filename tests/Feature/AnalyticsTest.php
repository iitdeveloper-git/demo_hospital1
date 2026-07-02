<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticsTest extends TestCase
{
    public function test_guest_cannot_access_executive_dashboard()
    {
        $response = $this->get(route('analytics.dashboard'));
        $response->assertRedirect('/login'); // Should redirect if unauthenticated
    }
}
