<?php

namespace App\Repositories;

use App\Models\Asset;

class AssetRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Asset();
    }
}
