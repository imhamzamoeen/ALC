<?php

namespace App\Repository\Eloquent;

use App\Classes\Enums\StatusEnum;
use App\Models\Course;
use App\Repository\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
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
    public function __construct(Course $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

    public function activeCourses(array $with = [], array $select = ['*'])
    {
        return $this->allBy(['status' => StatusEnum::Active, 'is_custom' => 0], $with, $select);
    }

    public function createCustom($data = '')
    {
        return $this->create([
            'title'         => __('Custom Course'),
            'description'   => $data,
            'created_by'    => auth()->user()->id,
            'is_custom'     => 1,
            'status'        => StatusEnum::Active,
        ]);
    }

   
}
