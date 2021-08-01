<?php

namespace App\Repositories;

use App\Models\RetentionData;
use App\Repositories\Interfaces\RetentionDataRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class RetentionDataRepository implements RetentionDataRepositoryInterface
{

    /**
     * @var
     */
    private $fileLocation;
    /**
     * @var
     */
    private $retentionData;


    /**
     * @param $fileLocation
     */
    public function __construct($fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        if (!isset($this->retentionData)) {
            $this->loadDataFromFile();
        }

        return $this->retentionData;
    }

    /**
     * Get CSV data into Model Collection
     * @return Collection
     *
     */
    public function loadDataFromFile(): Collection
    {
        $this->retentionData = collect();
        $fileContent = trim(File::get($this->fileLocation));

        $fileRows = explode("\n", $fileContent);

        for ($i = 1; $i < count($fileRows); $i++) {
            $row = explode(";", trim($fileRows[$i]));

            $this->retentionData->add(
                new RetentionData([
                    'user_id' => $row[0],
                    'created_at' => $row[1],
                    'onboarding_percentage' => $row[2],
                    'count_applications' => $row[3],
                    'count_accepted_applications' => $row[4],
                ])
            );
        }
        return $this->retentionData;
    }

}
