<?php

namespace App\Repository\Eloquent;

use App\Classes\Enums\StatusEnum;
use App\Models\TrialRequest;
use App\Notifications\NewTrialRequest;
use App\Repository\TrialRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class TrialRequestRepository extends BaseRepository implements TrialRequestRepositoryInterface
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
    public function __construct(TrialRequest $model)
    {
        $this->model = $model;
        $this->originalModel = $model;
    }

    public function createTrialAndNotify($student, $days = [], array $params = []){
        //dd($params);
        $input = array_merge(['student_id' => $student->id, 'status' => StatusEnum::TrialUnScheduled], $params);
        $trialRequest = $this->create($input);
        $input = array();
        foreach ($days as $day) {
            $input[] = ['day_id' => $day];
        }
        $data = array_fill_keys(['day_id'], $days);
        $trialRequest->days()->createMany($input);

        /*{PUSH-NOTIFICATION}*/
//dd($trialRequest);
        Notification::route('mail', [
            env('SALES_SUPPORT_EMAIL') => 'Support Team',
        ])->notify(new NewTrialRequest($trialRequest));
        return $trialRequest;
    }
}
