<?php

namespace App\Repository;

interface SubscriptionPlanRepositoryInterface extends EloquentRepositoryInterface
{
    public function fetchAllTypes();
}
