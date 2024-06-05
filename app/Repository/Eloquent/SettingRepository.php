<?php

namespace App\Repository\Eloquent;

use App\Classes\Enums\StatusEnum;
use App\Models\Setting;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
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
    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

    public function fetchAllCategories(){
        return $this->model->groupBy('category')->orderBy('category')->pluck('category');
    }

}
