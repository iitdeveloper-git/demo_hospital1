<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CmsTest extends TestCase
{
    public function test_guest_cannot_access_cms_dashboard()
    {
        $response = $this->get(route('cms.dashboard'));
        $response->assertRedirect('/login'); // Should redirect if unauthenticated
    }
}
