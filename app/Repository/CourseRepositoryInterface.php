<?php

namespace App\Repository;

use App\Classes\Enums\StatusEnum;

interface CourseRepositoryInterface extends EloquentRepositoryInterface
{
     public function activeCourses();

     public function createCustom($data);

     


}
