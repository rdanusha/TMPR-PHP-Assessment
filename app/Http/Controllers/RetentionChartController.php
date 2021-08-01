<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetentionChartController extends Controller
{
    /**
     * Display Retention Chart
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('chart');
    }
}
