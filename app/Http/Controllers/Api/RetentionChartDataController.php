<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RetentionDataRepositoryInterface;
use App\Repositories\Interfaces\WeeklyRetentionChartDataRepositoryInterface;
use App\Repositories\RetentionDataRepository;
use App\Repositories\WeeklyRetentionChartDataRepository;

class RetentionChartDataController extends Controller
{
    /**
     * @var WeeklyRetentionChartDataRepositoryInterface
     */
    private $retentionDataRepository;

    /**
     * @param WeeklyRetentionChartDataRepositoryInterface $retentionDataRepository
     */
    public function __construct(WeeklyRetentionChartDataRepositoryInterface $retentionDataRepository)
    {
        $this->retentionDataRepository = $retentionDataRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $weeklyRetentionChartData = $this->retentionDataRepository->getWeeklyRetentionChartData();

        return $weeklyRetentionChartData->getChartData();
    }

}
