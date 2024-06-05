<?php

namespace App\Repository\Eloquent;

use App\Classes\Enums\StatusEnum;
use App\Models\Availability;
use App\Models\Setting;
use App\Repository\AvailabilityRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AvailabilityRepository extends BaseRepository implements AvailabilityRepositoryInterface
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
    public function __construct(Availability $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

}
