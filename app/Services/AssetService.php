<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\AssetRepository;

class AssetService extends BaseService
{

    protected $repository;
    public function __construct()
    {
        $this->repository = new AssetRepository();
    }
    /**
     * Description : use to get all data asset
     *
     * @return object of eloquent
     */
    public function getAllData(): object
    {
        $data = $this->repository->getAllData();
        if ($data->count() == 0) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : use to get data by id
     *
     * @param int $id of asset that want to get
     * @return object of eloquent
     */
    public function getDataById(int $id): object
    {
        $data = $this->repository->getDataById($id);
        if (empty($data)) {
            throw new EmptyDataException();
        }
        return $data;
    }


    /**
     * Description : use to download asset
     *
     * @param int $id of asset
     * @return array for download controller
     */
    public function downloadById(int $id): array
    {
        $data = $this->getDataById($id);
        $filename = $data->filename;

        return [
            'path' => storage_path("app/public/document/$filename"),
            'filename' => $filename
        ];
    }
}
