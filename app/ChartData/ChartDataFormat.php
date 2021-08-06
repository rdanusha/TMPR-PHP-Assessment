<?php

namespace App\ChartData;

class ChartDataFormat
{
    private $xAxis;

    private $series;

    /**
     * @return mixed
     */
    public function getXAxis()
    {
        return $this->xAxis;
    }

    /**
     * @param mixed $xAxis
     */
    public function setXAxis($xAxis): void
    {
        $this->xAxis = $xAxis;
    }

    /**
     * @return mixed
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param mixed $series
     */
    public function setSeries($series): void
    {
        $this->series = $series;
    }


    public function getChartData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['series' => $this->getSeries(), 'xAxis' => $this->getXAxis()]);
    }
}
