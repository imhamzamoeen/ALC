<?php

namespace App\Http\Livewire\SalesSupport;

use App\Classes\AlertMessages;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Events\ClearStudentClassesEvent;
use App\Models\ChangesRequest;
use App\Models\Course;
use App\Models\TrialClass;
use App\Models\TrialRequest;
use App\Models\Notification as ModelsNotification;
use App\Models\Student;
use App\Models\User;
use App\Notifications\TrialClassUpdate;
use App\Repository\TrialClassRepositoryInterface;
use App\Repository\TrialRequestRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\WithPagination;

class AssignTeacher extends Component
{
    use WithPagination;
    public $current_date;    // this will be used for summary portion 
    public $option;
    public $slots;
    protected $paginationTheme = 'bootstrap';
    protected $trialRequests;
    protected $changesRequests;
    public $summary;
    public $teachers;
    public $currentRequest;
    public $courses;   // list of courses
    public $assign;  // is k andar ab sara data aaye ga
    public $CurrentOpenedChangeRequest;
    public $type;

    public $currentChangeRequest;    // this will handle all data related to current opened change request 
    protected $listeners = ['updateTrials' => 'resetForm', 'updateCustom' => 'updateCustomState', 'sendDateForSlots', 'UpdateLabel', 'RefreshSummary',];



    public function mount($status, TrialRequestRepositoryInterface $trialRequestRepository)
    {
        $this->ResetVariables();
        $this->current_date = Carbon::now();
        $this->type = $status ? $status : StatusEnum::TrialUnScheduled;              // at start status is empty so unscheduled is assigned
    }

    public function ResetVariables()
    {
        $this->courses = Course::all();
        $this->teachers = User::has('availability.slots')->role(UserTypesEnum::Teacher)->whereStatus(StatusEnum::Active)->get();
    }

    public function render(TrialRequest $trialRequestRepository)
    {
       
        if (strpos($this->type, 'trial') !== false)
            $this->trialRequests = $this->updateTrialList($trialRequestRepository);
        if ($this->type == 'completed_changes' ||  $this->type == 'pending_changes'  ||  $this->type == 'progress_changes')
            $this->changesRequests =  $this->updateChangesRequest($this->type);

        
        return view('front.sales-support.livewire.assign-teacher', [
            'trialRequests'  => $this->trialRequests,
            'teachers'  => $this->teachers,
            'summary'       => $this->summary,
            'changesRequests' => $this->changesRequests,
        ]);
    }

    protected $rules = [
        'assign.teacher_id'     => ['required', 'numeric', 'not_in:0'],
        'assign.course_id'        => ['required', 'numeric', 'exists:courses,id'],
        'assign.slot'        => ['required', 'numeric', 'max:48'],
        'assign.date'        => ['required', 'date', 'date_format:Y-m-d', 'after:today'],




    ];

    protected function changeRuels()
    {
        return [
            'CurrentOpenedChangeRequest.status' => ['required'],
            'CurrentOpenedChangeRequest.teacher_id' =>[ Rule::requiredIf(function ()  {
                return ($this->CurrentOpenedChangeRequest['change_type']=='course_change' || $this->CurrentOpenedChangeRequest['change_type']=='teacher_change') && $this->CurrentOpenedChangeRequest['status']=='completed' ;
            })],
            'CurrentOpenedChangeRequest.course_id' =>[ Rule::requiredIf(function ()  {
                return $this->CurrentOpenedChangeRequest['change_type']=='course_change'  && $this->CurrentOpenedChangeRequest['status']=='completed' ;
            })],
            'CurrentOpenedChangeRequest.change_type' => ['required', 'in:teacher_change,course_change']
        ];
    }

  

    protected $customMessage = [
        /*'required' => 'The :attribute field is required.',
        'max'      => 'The :attribute must not be greater than :max charactersssss.'*/
        'CurrentOpenedChangeRequest.teacher_id.required_if' => 'Please choose a Teacher ',
        'CurrentOpenedChangeRequest.course_id.required_if' => 'Please choose a Course ',

    ];

    protected $customName = [
        /* whereever you find these variable in error replace with given keywords */
        'assign.teacher_id'     => 'teacher',
        'assign.zoom_link'        => 'zoom link',
        'assign.starts_at'        => 'trial date',
        'assign.reason'           => 'reason',
        'assign.course_id'           => 'course_id',
        'CurrentOpenedChangeRequest.course_id' => "Course ID",
        'CurrentOpenedChangeRequest.teacher_id' => "Teacher ID",
        'CurrentOpenedChangeRequest.status' => "Change Request Status",



    ];

    public function OpenChangeModal($change)
    {
        $this->ResetVariables();
        $this->reset('currentChangeRequest', 'CurrentOpenedChangeRequest');
        $this->currentChangeRequest = $change;
        /* assigning variables so that they will be selected automatically when page loads */
        $this->CurrentOpenedChangeRequest['course_id'] =    $this->currentChangeRequest['student']['course']['id'];
        $this->CurrentOpenedChangeRequest['teacher_id'] =    $this->currentChangeRequest['student']['teacher']['id'];
        /* assigning variables so that they will be selected automatically when page loads */
        $this->CurrentOpenedChangeRequest['status']=  $this->currentChangeRequest['status'] ?? StatusEnum::ChangeRequestProgress; 
        
        $this->CurrentOpenedChangeRequest['change_type'] = $this->currentChangeRequest['change_type'];     /* because this field is used as hidden field so we need to fill it here */
        $this->dispatchBrowserEvent(
            'toggleModal',
            [
                'type' => 'open',
                'id' => '#change-request-' . $this->type
            ]
        );
    }

    public function openAssignModal($currentRequest, $option = 'trial_scheduled')
    {
        $this->ResetVariables();

        $this->reset('assign', 'currentRequest', 'option');
        $this->currentRequest = $currentRequest; //assign current request to passed trial object
        //dd($this->currentRequest);   
        $this->option = $option;


        if ($this->type != StatusEnum::TrialScheduled && $this->type != StatusEnum::TrialInvalid && empty($this->currentRequest['trial_class'])) {
            // dump("if");

            $this->assign['label'] = StatusEnum::TrialValid;
        } else {
            // dump('else');

            $this->assign['course_id'] = $this->currentRequest['student']['course']['id'];

            $this->updatedAssignCourseId($this->assign['course_id']);   // update list of teachers accordingly
            // $this->assign['starts_at'] = format_time(convertTimeToUSERzone($currentRequest['trial_class']['starts_at'], $currentRequest['student']['timezone']), false);
            $this->assign['teacher_id'] = $this->currentRequest['student']['teacher_id'];
            // $this->assign['zoom_link'] = $this->currentRequest['trial_class']['zoom_link'];
            $this->assign['label'] = $this->currentRequest['label'];
        }

        $this->assign['status'] = $this->currentRequest['status'];
        if ($this->currentRequest['status'] == StatusEnum::TrialUnSuccessful) {
            $this->assign['reason'] = $this->currentRequest['reason'];
        }
        // dd($this->assign);
        $this->dispatchBrowserEvent(
            'toggleModal',
            [
                'type' => 'open',
                'id' => '#assign-teacher-' . $this->type
            ]
        );
    }

    public function ChangeRequestSubmit()
    {
        /* if we place this validate in try then it goes to catch */
        $this->validate(
            $this->changeRuels(),
            $this->customMessage,
            $this->customName
        );


        try {
            DB::transaction(function () {
            
                $update_action = ChangesRequest::find($this->currentChangeRequest['id'])->update([
                    'status'    => $this->CurrentOpenedChangeRequest['status'],
                
                ]);
                if($this->CurrentOpenedChangeRequest['status']==StatusEnum::ChangeRequestCompleted)
                $UserModelUpdate=Student::find($this->currentChangeRequest['student']['id'])->query()->update(Arr::except($this->CurrentOpenedChangeRequest, ['change_type','status'])+['subscription_status'    =>  StatusEnum::TrialSuccessful]);
                  
            });

            /* dispatch event  to delete classes of student and notify him */
            ClearStudentClassesEvent::dispatch([
                'student_id' => $this->currentChangeRequest['student']['id'],
                'student_name'=>$this->currentChangeRequest['student']['id'],
                'user_email' => $this->currentChangeRequest['student']['user']['email'],
                'user_name' => $this->currentChangeRequest['student']['user']['name'],
                'change_type' =>  $this->currentChangeRequest['change_type'],
                'status' =>  $this->CurrentOpenedChangeRequest['status'],
            ]);

            $this->resetPage();         // incase of pagination it send to first page 
            $this->dispatchBrowserEvent(            // then show an alert message 
                'typeAlert',
                [
                    'type'     => 'change-request',
                    'result'    => 'change-request',
                    'status'    => 'success',
                    'message'   => __("The Change Requst for {$this->currentChangeRequest['change_type']} Executed Successfully"),
                    'alert'     => true,
                    'params'    => ['modal_id' => '#change-request-' . $this->type]
                ]
            );
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function submit(
        TrialClassRepositoryInterface $trialClassRepository,
        TrialRequestRepositoryInterface  $trialRequestRepository,
        StudentRepositoryInterface $studentRepository
    ) {

        $this->VerifyValidations();   // verify all inputs 


        try {

            DB::beginTransaction();

            if ($this->assign['label'] == StatusEnum::TrialInvalid) {

                // incase of giving trial invalid status .. just update the status of trial request and also update status of user subscription
                $trialRequestRepository->update(
                    ['id'       => $this->currentRequest['id']],
                    [
                        'status'   => StatusEnum::TrialInvalid,
                        'label'    => StatusEnum::TrialInvalid
                    ]
                );

                $studentRepository->update(
                    ['id' => $this->currentRequest['student_id']],
                    ['subscription_status' => StatusEnum::TrialInvalid]
                );
                DB::commit();

                $this->resetPage();
                $this->dispatchBrowserEvent(
                    'typeAlert',
                    [
                        'type'     => 'assigning_teacher',
                        'result'    => 'teacher_assigned',
                        'status'    => 'success',
                        'message'   => __(AlertMessages::TRIAL_SIGNED_INVALID),
                        'alert'     => true,
                        'params'    => ['modal_id' => '#assign-teacher-' . $this->type]
                    ]
                );
            } elseif ($this->assign['status'] == StatusEnum::TrialUnScheduled || $this->assign['status'] == StatusEnum::TrialScheduled || $this->assign['status'] == StatusEnum::TrialRescheduled || $this->assign['status'] == StatusEnum::TrialInvalid) {
                // incase ap trial ap teacher ko assign kr rhy ya reassign krny lgy 
                $this->assign['trial_request_id'] = $this->currentRequest['id'];

                $this->assign['status'] = ($this->assign['status'] == StatusEnum::TrialUnScheduled || $this->assign['status'] == StatusEnum::TrialRescheduled  || $this->assign['status'] == StatusEnum::TrialInvalid) ? StatusEnum::TrialScheduled : $this->assign['status'];
                $this->assign['starts_at'] = convertTimeToUTCzone(Carbon::parse(convert_slot_to_time_of_a_date($this->assign['date'], $this->assign['slot'], 'Y-m-d H:i:s')), User::find($this->assign['teacher_id'])->timezone);
                // $this->assign['starts_at'] = convertTimeToUTCzone(
                //     Carbon::parse($this->assign['starts_at']),
                //     $this->currentRequest['student']['timezone']
                // );
                //dd($this->assign['starts_at']);
                /*CREATING TRIAL*/



                $trialClass = TrialClass::updateOrCreate(['trial_request_id' => $this->currentRequest['id']], [
                    // here will come the data of the dmeo class
                    'starts_at' =>  $this->assign['starts_at'],
                    'status' =>   $this->assign['status'],
                    'teacher_id' => $this->assign['teacher_id'],
                    'student_id' => $this->currentRequest['student_id'],

                ]);  // agr new trial h tu create else update purana wala 

                if (!$trialClass->wasRecentlyCreated && $trialClass->wasChanged()) {
                    // updateOrCreate performed an update
                    // we have to delete old notificatipon as later a new notification will be created
                    ModelsNotification::where([
                        'json->trialClass->id' => $trialClass->id
                    ])->delete();
                }


                // $trialClass = $trialClassRepository->createOrUpdate(
                //     $this->assign,
                //     ['trial_request_id' => $this->currentRequest['id']]
                // );

                /*POST UPDATES*/
                $trialRequestRepository->update(
                    ['id' => $this->currentRequest['id']],
                    [
                        'status' => $this->assign['status'],
                        'label' => $this->assign['label'],
                    ],
                );
                $studentRepository->update(
                    ['id' => $this->currentRequest['student_id']],
                    ['subscription_status' => $this->assign['status'], 'teacher_id' => $this->assign['teacher_id']]
                );

                /*{PUSH-NOTIFICATION}*/
                Notification::send(
                    [User::find($this->currentRequest['student']['user_id']), User::find($this->assign['teacher_id'])],
                    new TrialClassUpdate($trialClass, $this->type)
                );

                DB::commit();
                $this->resetPage();
                $this->dispatchBrowserEvent(
                    'typeAlert',
                    [
                        'type'     => 'assigning_teacher',
                        'result'    => 'teacher_assigned',
                        'status'    => 'success',
                        'message'   => __(AlertMessages::TEACHER_ASSIGNED_SUCCESS),
                        'alert'     => true,
                        'params'    => ['modal_id' => '#assign-teacher-' . $this->type]
                    ]
                );
            } else {

                // ap trial ka status update krny lgy 
                $trialRequestRepository->update(
                    ['id'       => $this->currentRequest['id']],
                    [
                        'status'   => $this->assign['status'],
                        'reason'   => isset($this->assign['reason']) ? $this->assign['reason'] : null
                    ]
                );

                $trialClassRepository->update(
                    ['trial_request_id' => $this->currentRequest['id']],
                    ['status' => $this->assign['status']]
                );

                $studentRepository->update(
                    ['id' => $this->currentRequest['student_id']],
                    ['subscription_status' => $this->assign['status']]
                );
                DB::commit();
                $this->resetPage();         // incase of pagination it send to first page 
                $this->dispatchBrowserEvent(            // then show an alert message 
                    'typeAlert',
                    [
                        'type'     => 'assigning_teacher',
                        'result'    => 'teacher_assigned',
                        'status'    => 'success',
                        'message'   => __(AlertMessages::TEACHER_ASSIGNED_SUCCESS),
                        'alert'     => true,
                        'params'    => ['modal_id' => '#assign-teacher-' . $this->type]
                    ]
                );
            }
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();
            $this->dispatchBrowserEvent(
                'typeAlert',
                [
                    'type' => 'assigning_teacher',
                    'result' => 'teacher_assigned',
                    'status' => 'error',
                    'message' => __(AlertMessages::TEACHER_ASSIGNED_FAILED),
                    'alert' => true,
                    'params' => ['modal_id' => '#assign-teacher-' . $this->type]
                ]
            );
        }
    }


    // public function updated($propertyName)
    // {

    //     $this->validateOnly($propertyName);
    // }
    public function updated($propertyName)
    {

        $this->validateOnly($propertyName, $this->rules, $this->customMessage, $this->customName);
    }

    public function updateTrialList($trialRequestRepository)
    {
        $trialRequestRepository = $trialRequestRepository->where('status', $this->type);
        if ($this->type == StatusEnum::TrialUnScheduled) {
            $trialRequestRepository = $trialRequestRepository->orWhere('status', StatusEnum::TrialRescheduled);
        }
        return  $trialRequestRepository->with('trialClass')->orderBy('id', 'desc')->paginate(6);
    }

    public function updateChangesRequest($type)
    {
       
        try {
            return   ChangesRequest::type($type)->with([
                'Student' => function ($query) {
                    return $query->Select('id', 'name', 'gender', 'teacher_id', 'course_id', 'user_id', 'timezone', 'age', 'gender');
                },
                'Student.teacher' => function ($query) {
                    return $query->Select('id', 'name', 'email', 'timezone');
                },
                'Student.user' => function ($query) {
                    return $query->Select('id', 'name', 'email', 'timezone', 'phone', 'country');
                },
                'Student.course' => function ($query) {
                    return $query->Select('id', 'title', 'description');
                },
                'Course' => function ($query) {
                    return $query->Select('id', 'title', 'description');
                },

            ])->orderBy('id', 'desc')->paginate(6);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function resetForm($type, TrialRequest $trialRequestRepository)
    {
        $this->type = $type;
        if ($type == 'summary') {
            $this->updateSummary();
        } else if (property_exists(new StatusEnum, $type)) {
       
            $this->changesRequests = $this->updateChangesRequest($type);
        } else {
            $this->trialRequests = $this->updateTrialList($trialRequestRepository);
        }
    }

    public function sendDateForSlots($date)
    {
        $this->assign['date'] = Carbon::parse($date)->format('Y-m-d');
        $this->assign['slot'] = null;
    }

    public function updateSummary()
    {
        // dd($this->current_date);
        $this->summary['details'] = TrialRequest::whereYear('created_at', $this->current_date->year)->whereMonth('created_at', $this->current_date->month)->groupBy('status')->selectRaw('COUNT(`status`) as count, status')->get();
        $this->summary['total'] = @$this->summary['details']->sum('count');
        // dd($this->summary);
        $this->dispatchBrowserEvent(
            'refresh-chart',
            ['data' => $this->summary['details'], 'date' => $this->current_date->format('F')]

        );
    }

    public function VerifyValidations()
    {
        if ($this->assign['label'] == StatusEnum::TrialValid) {
            if ($this->option == 'details')   // he has chosen view details. then we need two things 
            {
                $this->validate(
                    (@$this->assign['status'] == StatusEnum::TrialUnSuccessful) ? array_merge(['assign.status' => ['required', 'string']], ['assign.reason' => ['required']]) : ['assign.status' => ['required', 'string']],
                    $this->customMessage,
                    $this->customName,
                );
            } else {
                // we need all details as he has chosen another option
                $this->validate(
                    $this->rules,
                    $this->customMessage,
                    $this->customName
                );
            }
        }
    }
    // check when assign course id changed
    public function updatedAssignCourseId($value)
    {
        if (!empty($value)) {
            $this->assign['teacher_id'] = null;
            $this->teachers = Course::with(['users' => function ($query) {
                $query->has('availability.slots');
            }])->find(str_replace('"', "", $value));
            if ($this->teachers->title = 'Custom Course') {
                $this->teachers = User::has('availability.slots')->role(UserTypesEnum::Teacher)->whereStatus(StatusEnum::Active)->get();
            } else {
                $this->teachers = $this->teachers->users;
            }
        }


        //
    }

    public function updatedAssignSlot($value)
    {
        // dd($value);
        // if (!empty($value)) {

        //     $this->teachers = Course::with(['users' => function ($query) {
        //         $query->has('availability.slots');
        //     }])->find(str_replace('"', "", $value));
        //     $this->teachers = $this->teachers->users;
        // }

    }




    public function UpdateLabel($value = StatusEnum::TrialValid)
    {

        $this->assign['label'] = $value;
    }



    public function UpdatedCurrentOpenedChangeRequestCourseId($value)
    {

        if (!empty($value)) {

            $this->teachers = Course::with(['users' => function ($query) {
                $query->has('availability.slots');
            }])->find(str_replace('"', "", $value));
            $this->teachers = $this->teachers->users;
        }
    }



    public function RefreshSummary($value)
    {

        $value = Carbon::parse($value);
        // dd($value->diffInMonths(Carbon::now()));
        if ($value->diffInMonths(Carbon::now()) <= 6 && $value->lt(Carbon::now())) {
            $this->current_date = $value;
        }
        $this->updateSummary();
    }
}
