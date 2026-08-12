<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_localized_home_routes_are_registered_explicitly(): void
    {
        foreach (['en', 'ua', 'ru'] as $locale) {
            $this->get('/'.$locale)->assertOk();
        }
    }

    public function test_unknown_or_cross_branch_service_returns_not_found(): void
    {
        $this->get('/services/not-a-real-service')->assertNotFound();
        $this->get('/en/services/not-a-real-service')->assertNotFound();
    }
}
