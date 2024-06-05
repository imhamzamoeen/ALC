<?php

namespace App\Repository\Eloquent;

use App\Models\LibraryFile;
use App\Models\SharedLibrary;
use App\Repository\LibraryFilesRepositoryInterface;
use App\Repository\SharedLibraryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class LibraryFilesRepository extends BaseRepository implements LibraryFilesRepositoryInterface
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
    public function __construct(LibraryFile $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

}
