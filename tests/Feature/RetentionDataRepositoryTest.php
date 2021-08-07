<?php

namespace Tests\Feature;

use App\Models\RetentionData;
use App\Repositories\RetentionDataRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Mockery;
use Tests\TestCase;

class RetentionDataRepositoryTest extends TestCase
{

    /**
     * @return string
     */
    public function getFileLocation(): string
    {
        $fileLocation = storage_path('app/export.csv');
        return $fileLocation;
    }

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

    public function test_is_csv_file_exist()
    {
        $fileLocation = $this->getFileLocation();
        $this->assertFileExists($fileLocation);
    }

    public function test_is_csv_file_not_exist()
    {
        $fileLocation = storage_path('app/test-file-not-exist.csv');
        $this->expectException(FileNotFoundException::class);
        $repo = new RetentionDataRepository($fileLocation);
    }

    public function test_check_file_data_method_output()
    {
        $actual = $this->getTestRetentionDataRepository()->getData();
        $this->assertEquals(2, count($actual));
    }

    public function test_load_data_from_csv_file()
    {
        $actual = $this->getTestRetentionDataRepository()->loadDataFromFile();

        $expected = collect([
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
        ]);

        $this->assertEquals($expected, $actual);

    }


}
