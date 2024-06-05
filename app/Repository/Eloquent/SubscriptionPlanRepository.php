<?php

namespace App\Repository\Eloquent;

use App\Models\SubscriptionPlan;
use App\Repository\SubscriptionPlanRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanRepository extends BaseRepository implements SubscriptionPlanRepositoryInterface
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
    public function __construct(SubscriptionPlan $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

    public function fetchAllTypes(){
        return $this->model->groupBy('type')->orderBy('type')->pluck('type');
    }

}
