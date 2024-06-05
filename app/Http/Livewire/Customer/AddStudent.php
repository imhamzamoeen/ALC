<?php

namespace App\Http\Livewire\Customer;

use App\Classes\AlertMessages;
use App\Classes\AlQuranConfig;
use App\Classes\Enums\StatusEnum;
use App\Repository\CourseRepositoryInterface;
use App\Repository\TrialRequestRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddStudent extends Component
{
    public $courses;
    public $user;
    public $students;

    /*Form Fields*/
    public $name;
    public $gender;
    public $age;
    public $course_id;
    public $custom_course;
    public $days;
    public $shift_id;
    public $timezone;
    public $request_date;
    public $teacher_preference;


    public $trial_1 = true;
    public $trial_2 = false;
    public $trial_3 = false;
    public $trial1_status = '';
    public $trial2_status = '';
    public $trial3_status = '';
    public $progress = 0;

    protected $courseRepository;
    protected $studentRepository;
    protected $trialRequestRepository;

    protected $listeners = ['resetStudentForm' => 'resetForm', 'updateCustom' => 'updateCustomState', 'setValue'];

    protected $rules = [
        'name'          => ['required', 'max:64', 'regex:/^[\pL\s\-]+$/u'],
        'gender'        => ['required', 'max:10'],
        'age'           => ['required', 'numeric', 'min:2', 'max:' . AlQuranConfig::MaxAge],
        'course_id'     => ['required', 'numeric'],
        'custom_course' => ['required_if:course_id,==,0', 'nullable'],
        'days'          => ['required'],
        'shift_id'      => ['required', 'numeric', 'not_in:0'],
        'timezone'      => ['required', 'not_in:0'],
        'request_date'  => ['max:20'],
        'teacher_preference' => ['required', 'string', 'in:male,female,any'],
    ];

    protected $messages = [
        'course_id.required' => 'At least 1 course should be selected',
        'custom_course.required_if' => 'Custom course field is required',
        'shift_id.not_in' => 'The selected shift is invalid',
    ];

    public function mount($courses)
    {
        //$this->course_id = $this->courses[0]->id;
        $this->updateStudentList();
    }

    public function submit(
        StudentRepositoryInterface $studentRepository,
        TrialRequestRepositoryInterface $trialRequestRepository,
        CourseRepositoryInterface $courseRepository
    ) {
        $dayFlag = false;
        // if(is_array($this->days)){
        //     foreach ($this->days as $key => $day){
        //         if($day && $day != 0){
        //             $dayFlag = true;
        //         }else{
        //             unset($this->days[$key]);
        //         }
        //     }
        // }
        // if(!$dayFlag){
        //     $this->reset('days');
        // }

        $validatedData = $this->validate();
        if (count($this->students) == AlQuranConfig::MaxProfiles) {
            $this->dispatchBrowserEvent(
                'typeAlert',
                [
                    'type'     => 'adding_student',
                    'result'    => 'limit_exceeded',
                    'status'    => 'warning',
                    'message'   => __(AlertMessages::STUDENT_LIMIT_EXCEEDED),
                    'alert'     => true
                ]
            );
            return false;
        }
        $this->trial3_status = 'completed';

        try {
            DB::beginTransaction();

            if ($this->course_id == 0) {
                $this->course_id = $courseRepository->createCustom($this->custom_course)->id;
            }

            $input = [
                'name'                  => $this->name,
                'gender'                => $this->gender,
                'age'                   => $this->age,
                'course_id'             => $this->course_id,
                'custom_course'         => $this->custom_course,
                'days'                  => $this->days,
                'shift_id'              => $this->shift_id,
                'timezone'              => $this->timezone,
                'subscription_status'   => StatusEnum::TrialRequested
            ];

            /*Creating a new student instance*/
            $arrayData = array('name', 'gender', 'age', 'course_id', 'shift_id', 'timezone', 'subscription_status');
            $sData = array_intersect_key($input, array_flip($arrayData));
            $studentData = array_merge($sData, ['user_id' => auth()->user()->id]);

            $student = $studentRepository->create($studentData);
            /*Creating a trial request for the student*/
            $params = ['teacher_preference'=>$this->teacher_preference];
            /*if(!is_null($this->request_date)){
                $params['request_date'] = Carbon::parse($this->request_date)->toDate();
            }*/
            $trialRequest = $trialRequestRepository->createTrialAndNotify($student, $input['days'], $params);
            $this->updateStudentList();

            DB::commit();
            $this->dispatchBrowserEvent(
                'typeAlert',
                [
                    'type'     => 'adding_student',
                    'result'   => 'student_added',
                    'status'   => 'success',
                    'message'  => __(AlertMessages::STUDENT_ADDED_SUCCESS)
                ]
            );
        } catch (\Throwable $e) {
            //dd($e);
            DB::rollback();
            $this->dispatchBrowserEvent(
                'typeAlert',
                [
                    'type'     => 'adding_student',
                    'result'   => 'student_error',
                    'status'   => 'error',
                    'message'  => __(AlertMessages::STUDENT_ADDED_FAILED),
                    'alert'    => true
                ]
            );
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName == 'course_id') {
            $this->validateOnly('custom_course');
        }
    }

    public function toggleTab($trial_1, $trial_2, $trial_3)
    {
        if ($trial_1) {
            $this->trial1_status = 'active';
            $this->trial2_status = '';
            $this->trial3_status = '';
            $this->progress = 0;
        }
        if ($trial_2) {
            $this->validate([
                'name'     => ['required', 'max:64', 'regex:/^[\pL\s\-]+$/u'],
                'gender'   => ['required'],
                'age'      => ['required', 'numeric', 'min:2', 'max:100']
            ]);

            $this->trial1_status = 'completed';
            $this->trial2_status = 'active';
            $this->trial3_status = '';
            $this->progress = 50;
        }
        if ($trial_3) {
            $this->validate([
                'course_id'        => ['required'],
                'custom_course'    => ['required_if:course_id,==,0', 'nullable']
            ]);
            $this->dispatchBrowserEvent('setTimezone');
            $this->trial1_status = 'completed';
            $this->trial2_status = 'completed';
            $this->trial3_status = 'active';
            $this->progress = 100;
        }
        $this->trial_1 = $trial_1;
        $this->trial_2 = $trial_2;
        $this->trial_3 = $trial_3;
    }

    public function resetForm($reopen = false)
    {
        $this->reset(
            'name',
            'gender',
            'age',
            'course_id',
            'custom_course',
            'days',
            'shift_id',
            'timezone',
            'trial_1',
            'trial_2',
            'trial_3',
            'trial1_status',
            'trial2_status',
            'trial3_status',
            'progress',
            'request_date',
            'teacher_preference'
        );
        $this->trial1_status = 'active';
        if (count($this->students) == AlQuranConfig::MaxProfiles) {
            $this->dispatchBrowserEvent(
                'typeAlert',
                [
                    'type'     => 'adding_student',
                    'result'   => 'limit_exceeded',
                    'status'   => 'warning',
                    'message'  => __(AlertMessages::STUDENT_LIMIT_EXCEEDED),
                    'alert'    => true
                ]
            );
            return false;
        }
    }

    public function updateCustomState($state, $value)
    {
        $this->$state = $value;
    }

    public function render()
    {
        return view('front.customer.livewire.add-student');
    }

    public function updateStudentList()
    {
        $this->user = auth()->user();
        $this->students = $this->user->profiles()->with(['trialRequest' => function ($que) {
            $que->with(['trialClass']);
        }])->get();
    }

    public function setValue($params)
    {
        if (count($params)) {
            foreach ($params as $key => $param) {
                $this->{$key} = $param;
            }
        }
    }
}
