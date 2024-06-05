<?php

namespace App\Repository\Eloquent;

use App\Models\Student;
use App\Repository\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    /**
     * @var Eloquent | Model
     */
    protected $model;

    /**
     * @var Eloquent | Model
     */
    protected $originalModel;

    /**
     * RepositoriesAbstract constructor.
     * @param Model|Eloquent $model
     */
    public function __construct(Student $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }
}
