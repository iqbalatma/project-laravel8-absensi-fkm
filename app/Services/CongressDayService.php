<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Models\CongressDay;
use App\Repositories\CongressDayRepository;
use Illuminate\Support\Facades\DB;

class CongressDayService
{
    private const CONGRESS_DAY_SELECT_COLUMN = [
        "id", "location", "h_day",
    ];
    /**
     * Description : use to get list data of congress day
     *
     * @return object
     */
    public function getAllData(): object
    {
        return (new CongressDayRepository())->getAllData(self::CONGRESS_DAY_SELECT_COLUMN);
    }


    /**
     * Description : use to get single data of congress day by id
     *
     * @param int $id of congress day
     * @return object
     */
    public function getDataById(int $id): object
    {
        $data = (new CongressDayRepository())->getDataById($id, self::CONGRESS_DAY_SELECT_COLUMN);
        if (empty($data)) {
            throw new EmptyDataException();
        }

        return $data;
    }


    /**
     * Description : Use for add new congress day
     *
     * @param array $requestedData
     * @return object
     */
    public function addNewData(array $requestedData): object
    {
        return (new CongressDayRepository())->addNewData($requestedData);
    }


    /**
     * Description : use to update congress day
     *
     * @param int $id of congress day
     * @param array $reuqestedData that already validated
     */
    public function updateDataById(int $id, array $requestedData)
    {
        $updated = (new CongressDayRepository())->updateDataById($id, $requestedData, self::CONGRESS_DAY_SELECT_COLUMN);

        if (!$updated) {
            throw new EmptyDataException();
        }

        return $updated;
    }


    /**
     * Description : Service for soft delete congress day
     *
     * @param int $id of congress day
     * @return bool status of deletion
     */
    public function deleteDataById(int $id): bool
    {
        return (new CongressDayRepository())->deleteDataById($id);
    }
}
