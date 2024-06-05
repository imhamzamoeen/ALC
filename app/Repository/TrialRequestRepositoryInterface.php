<?php

namespace App\Repository;

interface TrialRequestRepositoryInterface extends EloquentRepositoryInterface
{
    public function createTrialAndNotify($student, $days = [], array $params = []);
}
