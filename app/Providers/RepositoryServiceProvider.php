<?php

namespace App\Providers;

use App\Repositories\Interfaces\RetentionDataRepositoryInterface;
use App\Repositories\Interfaces\WeeklyRetentionChartDataRepositoryInterface;
use App\Repositories\RetentionDataRepository;
use App\Repositories\WeeklyRetentionChartDataRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(RetentionDataRepositoryInterface::class, function ($app) {
            return new RetentionDataRepository(storage_path('app/export.csv'));
        });

        $this->app->bind(
            WeeklyRetentionChartDataRepositoryInterface::class,
            WeeklyRetentionChartDataRepository::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
