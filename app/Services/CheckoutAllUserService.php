<?php

namespace App\Services;

use App\Exceptions\EmptyDataException;
use App\Repositories\AssetRepository;
use App\Repositories\CheckinStatusRepository;
use App\Repositories\CongressDayRepository;

class CheckoutAllUserService extends BaseService
{
    public function checkoutAllUserByDate(array $requestedData)
    {
        $congressDay = (new CongressDayRepository())->getDataByHDay($requestedData['congress_date']);

        if (empty($congressDay)) {
            throw new EmptyDataException();
        }

        $congressDayId = $congressDay->id;

        return (new CheckinStatusRepository())->checkoutAllUser($congressDayId);
    }
}
