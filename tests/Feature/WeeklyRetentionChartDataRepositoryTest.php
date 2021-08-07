<?php

namespace Tests\Feature;

use App\ChartData\ChartDataFormat;
use App\Models\RetentionData;
use App\Repositories\RetentionDataRepository;
use App\Repositories\WeeklyRetentionChartDataRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class WeeklyRetentionChartDataRepositoryTest extends TestCase
{

    /**
     * @return RetentionDataRepository|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    public function getTestRetentionDataRepository()
    {
        $mockOutput = Mockery::mock(RetentionDataRepository::class);
        $mockOutput->shouldReceive('loadDataFromFile', 'getData')->andReturn(collect([
            new RetentionData([
                'user_id' => 1212,
                'created_at' => "2016-07-18",
                'onboarding_percentage' => 23,
                'count_applications' => 1,
                'count_accepted_applications' => 0,
            ]),
            new RetentionData([
                'user_id' => 2323,
                'created_at' => "2016-07-25",
                'onboarding_percentage' => 34,
                'count_applications' => 0,
                'count_accepted_applications' => 0,
            ]),
        ]));

        return $mockOutput;
    }


    public function getTestChartData()
    {
        $mockOutput = Mockery::mock(ChartDataFormat::class);
        $mockOutput->shouldReceive('getSeries')->andReturn(
            [[
                'name' => '2016-07-18',
                'data' => collect([100, 0])
            ],
                [
                    'name' => '2016-07-25',
                    'data' => collect([100, 100])
                ]]
        );
        $mockOutput->shouldReceive('getXAxis')->andReturn(
            [23, 34]
        );

        return $mockOutput;
    }

    public function test_check_get_weekly_retention_chart_data_output()
    {
        $mockOutput = $this->getTestRetentionDataRepository();
        $repo = new WeeklyRetentionChartDataRepository($mockOutput);

        $chartDataFormat = $this->getTestChartData();
        $actualOutput = $repo->getWeeklyRetentionChartData();
        $this->assertEquals($chartDataFormat->getSeries(), $actualOutput->getSeries());
        $this->assertEquals($chartDataFormat->getXAxis(), $actualOutput->getXAxis());
    }

}
