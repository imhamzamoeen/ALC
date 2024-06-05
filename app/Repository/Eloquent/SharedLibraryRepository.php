<?php

namespace App\Repository\Eloquent;

use App\Models\SharedLibrary;
use App\Repository\SharedLibraryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SharedLibraryRepository extends BaseRepository implements SharedLibraryRepositoryInterface
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
    public function __construct(SharedLibrary $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

}
