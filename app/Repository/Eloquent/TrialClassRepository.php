<?php

namespace App\Repository\Eloquent;

use App\Classes\Enums\StatusEnum;
use App\Models\TrialClass;
use App\Repository\TrialClassRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TrialClassRepository extends BaseRepository implements TrialClassRepositoryInterface
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
    public function __construct(TrialClass $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

}
