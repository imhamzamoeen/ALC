<?php

namespace App\Repository;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{

    public function scopeRoleUser();
}
