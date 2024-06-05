<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Eloquent | Model
     */
    public $model;

    /**
     * @var Eloquent | Model
     */
    protected $originalModel;

    /**
     * RepositoriesAbstract constructor.
     * @param Model|Eloquent $model
     */
    public function __construct(User $model)
    {

        $this->model = $model;
        $this->originalModel = $model;
    }

    public function scopeRoleUser(){
        $this->model=$this->model->RoleUser();
        // $this->originalModel=$this->originalModel->RoleUser();
      

    }

  
}
