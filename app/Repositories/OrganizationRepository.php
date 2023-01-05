<?php

namespace App\Repositories;

use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class OrganizationRepository extends BaseRepository
{
    protected  $model;
    public function __construct()
    {
        $this->model = new Organization();
    }
}
