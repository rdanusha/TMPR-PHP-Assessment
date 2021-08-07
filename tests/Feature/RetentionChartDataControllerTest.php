<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetentionChartDataControllerTest extends TestCase
{

    /**
     * Test chart data api response
     */
    public function test_get_data_from_api()
    {
        $this->get('/api/charts/get-weekly-retention-data')
            ->assertStatus(200)
            ->assertJsonFragment([["data" => [19, 42, 53, 61, 61, 65, 66, 66, 98, 100, 100], "name" => "2016-08-01"]])
            ->assertHeader("Content-Type", "application/json");
    }

    public function test_if_provide_a_wrong_api_endpoint()
    {
        $this->get('/api/charts/get-retention-data')
            ->assertStatus(404);
    }

}
