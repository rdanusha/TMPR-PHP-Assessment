<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RetentionDataRepositoryInterface;
use App\Repositories\Interfaces\WeeklyRetentionChartDataRepositoryInterface;
use App\Repositories\RetentionDataRepository;
use App\Repositories\WeeklyRetentionChartDataRepository;

/**
 * @OA\Get (
 * path="/api/charts/get-weekly-retention-data",
 * description="Get weekly retention data",
 * tags={"Retention Chart"},
 *     @OA\Response(
 *      response=200,
 *      description="Success",
 *           @OA\JsonContent(
 *            @OA\Property(property="series", type="json", example="[{'name':'2016-07-18','data':[100,100,99,47,44,41,41,41,41,40,29]},{'name':'2016-07-25','data':[100,100,99,47,44,41,41,41,41,40,29]}]"),
 *            @OA\Property(property="xAxis", type="json", example="[0,35,40,45,50,55,60,65,95,99,100]"),
 *         )
 *      )
 * )
 *
 */
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


    public function index()
    {
        $weeklyRetentionChartData = $this->retentionDataRepository->getWeeklyRetentionChartData();

        return $weeklyRetentionChartData->getChartData();
    }

}
