<?php

namespace App\Repositories\Interfaces;

use App\ChartData\ChartDataFormat;

interface WeeklyRetentionChartDataRepositoryInterface
{
    public function getWeeklyRetentionChartData(): ChartDataFormat;
}
