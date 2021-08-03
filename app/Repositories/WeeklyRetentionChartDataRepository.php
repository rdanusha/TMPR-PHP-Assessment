<?php

namespace App\Repositories;

use App\ChartData\ChartDataFormat;
use App\Models\RetentionData;
use App\Repositories\Interfaces\RetentionDataRepositoryInterface;
use App\Repositories\Interfaces\WeeklyRetentionChartDataRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WeeklyRetentionChartDataRepository implements WeeklyRetentionChartDataRepositoryInterface
{

    /**
     * @var RetentionDataRepositoryInterface
     */
    private $retentionDataRepository;

    /**
     * @param RetentionDataRepositoryInterface $retentionDataRepository
     */
    public function __construct(RetentionDataRepositoryInterface $retentionDataRepository)
    {
        $this->retentionDataRepository = $retentionDataRepository;
    }

    /**
     * Get given onboarding percentages
     * @param $retentionData
     * @return mixed
     */
    private function getOnboardingPercentages($retentionData): array
    {
        return $retentionData->pluck('onboarding_percentage')->unique()->sort()->values()->toArray();
    }

    /**
     * Get weekly wise onboarding count percentages
     * @param Collection $weeklyRetentionData
     * @param $onboardingPercentages
     * @param $onboardingPercentagesCount
     * @return Collection
     */
    private function weeklyRecordsGroupedByPercentage(Collection $weeklyRetentionData, $onboardingPercentages, $onboardingPercentagesCount): Collection
    {
        return $weeklyRetentionData->map(function (Collection $collection) use ($onboardingPercentages, $onboardingPercentagesCount) {
            $stepsBefore = 0;

            $weekOnboardingData = $collection->groupBy('onboarding_percentage')
                ->map(static function (Collection $collection) {
                    return $collection->count();
                })->sortKeysDesc();


            $totalSum = $weekOnboardingData->sum();

            $weekOnboardDataPercentages = $weekOnboardingData->map(function ($item) use (&$stepsBefore, $totalSum) {
                $stepsBefore += $item;
                return (int)round(($stepsBefore / $totalSum) * 100);
            })->sortKeys();

            $lastStep = 0;

            for ($i = $onboardingPercentagesCount - 1; $i >= 0; $i -= 1) {
                if (isset($weekOnboardDataPercentages[$onboardingPercentages[$i]])) {
                    $lastStep = $weekOnboardDataPercentages[$onboardingPercentages[$i]];
                } else {
                    $weekOnboardDataPercentages[$onboardingPercentages[$i]] = $lastStep;
                }
            }

            return $weekOnboardDataPercentages->sortKeys();
        })->sortKeys();
    }

    /**
     * Get weekly retention data from the given data
     * @param Collection $retentionDataSet
     * @return Collection
     */
    private function makeWeeklyRetentionData(Collection $retentionDataSet): Collection
    {
        $weeklyRetentionData = $retentionDataSet->groupBy(function (RetentionData $retentionData) {
            return $retentionData->created_at->format("Y,W");
        });

        return $weeklyRetentionData->mapWithKeys(function ($value, $key) {
            $list = explode(",", $key);
            $year = $list[0];
            $week = $list[1];
            $date = Carbon::now();
            $date->setISODate($year, $week);
            return [$date->startOfWeek()->format("Y-m-d") => $value];
        });
    }

    /**
     * Get weekly return chart data
     * @return ChartDataFormat
     */
    public function getWeeklyRetentionChartData(): ChartDataFormat
    {
        $retentionData = $this->retentionDataRepository->getData();
        $onboardingPercentages = $this->getOnboardingPercentages($retentionData);
        $weeklyRetentionData = $this->makeWeeklyRetentionData($retentionData);
        $onboardingPercentagesCount = count($onboardingPercentages);

        $chartRecords = $this->weeklyRecordsGroupedByPercentage($weeklyRetentionData, $onboardingPercentages, $onboardingPercentagesCount)->map(function (Collection $value, $key) {
            return [
                'name' => $key,
                'data' => $value->values(),
            ];
        })->values();

        $chartDataFormat = new ChartDataFormat();
        $chartDataFormat->setSeries($chartRecords->toArray());
        $chartDataFormat->setXAxis($onboardingPercentages);

        return $chartDataFormat;
    }
}
