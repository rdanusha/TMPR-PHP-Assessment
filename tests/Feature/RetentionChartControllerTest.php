<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetentionChartControllerTest extends TestCase
{

    /**
     * test chart landing page loading
     */
    public function test_display_chart_landing_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
