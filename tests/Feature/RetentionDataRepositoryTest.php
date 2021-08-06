<?php

namespace Tests\Feature;

use App\Repositories\RetentionDataRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RetentionDataRepositoryTest extends TestCase
{


    public function test_is_csv_file_exist()
    {
        $fileLocation = storage_path('app/export.csv');
        $this->assertFileExists($fileLocation);
    }

    public function test_check_file_data()
    {
        $fileLocation = storage_path('app/export.csv');
        $repo = new RetentionDataRepository($fileLocation);
        $this->assertEquals(339, count($repo->getData()));
    }
}
