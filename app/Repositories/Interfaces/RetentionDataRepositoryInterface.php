<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface RetentionDataRepositoryInterface
{
    public function getData(): Collection;
}
