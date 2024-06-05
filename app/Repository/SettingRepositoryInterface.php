<?php

namespace App\Repository;

interface SettingRepositoryInterface extends EloquentRepositoryInterface
{
    public function fetchAllCategories();
}
