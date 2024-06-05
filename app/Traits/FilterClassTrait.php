<?php

namespace App\Traits;

use App\Classes\Enums\StatusEnum;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait FilterClassTrait
{

    

  
    public function SchedulefilterClasses()
    {
        /* For Teacher */
        foreach ($this->classes as $class) {
            $class->class_time = convertTimeToUSERzone($class->class_time, $this->model->timezone); //convert class  time to user's timezone
            $class->live_status = 0;

            $tempTime = Carbon::parse($class->class_time)->addMinutes(31); // add 31 minutes to class time
            $live = Carbon::now($this->model->timezone)->between(Carbon::parse($class->class_time)->subMinute(), $tempTime);  //check if current time of user's timezone is between current class class time or not 
            if ($live) { //if it's live
                $class->live_status = 1;   //add attribute live status with value 1 
                $class->status = beautify_slug(StatusEnum::ONGOING);
                $this->liveClass = $class; // add this class to live class variable 
            }
            if ($class->class_time->gt(Carbon::now($this->model->timezone)->subMinutes(30)) && !$class->class_time->gt(Carbon::tomorrow($this->model->timezone)->subMinutes())) { // if class time is > current time of user's zone - 30 min and less than rat k 11:59 bjy
                $this->todayClasses[] = $class; //push that to today classes's array
            } elseif ($class->class_time->gt(Carbon::tomorrow($this->model->timezone)->subMinute())) {  // if the class time is greater than equal to tonight's 12 
                $this->nextClasses[] = $class; //push that to next classes 
            } elseif (Carbon::now($this->model->timezone)->gt($tempTime)) { // if the current time of the user's timezone is > class time add it to previous classes
                // if($class->teacher_status != StatusEnum::PRESENT){
                //     $class->teacher_status = StatusEnum::ABSENT;
                // }
                // if($class->teacher_status != StatusEnum::PRESENT){
                //     $class->status = StatusEnum::CLASSMISSED;
                // }elseif ($class->teacher_status != StatusEnum::PRESENT){
                //     $class->status = StatusEnum::TEACHERABSENT;
                // }

                // if ($class->teacher_status != StatusEnum::ATTENDED) {
                //     $class->status = StatusEnum::CLASSMISSED;
                // } else {
                //     $class->status = StatusEnum::COMPLETED;
                // }
                /*Reason at front end teacher status is directly showing */
                // $this->previousClasses[] = $class;
                $this->previousClasses->push($class);
            }
        }

        $this->previousClasses = $this->previousClasses->sortBy([['class_time', 'DESC'],]);  // so that latest missed classes comes first

    }


    public function TimelinefilterClasses()
    {
        /* For Student */
        foreach ($this->classes as $class) {
            $class->class_time = convertTimeToUSERzone($class->class_time, $this->model->timezone);
            $class->live_status = 0;

            $tempTime = Carbon::parse($class->class_time)->addMinutes(31);
            $live = Carbon::now($this->model->timezone)->between(Carbon::parse($class->class_time)->subMinute(), $tempTime);

            if (Carbon::now($this->model->timezone)->gt($tempTime)) {
                if ($class->teacher_status != StatusEnum::PRESENT) {
                    $class->teacher_status = StatusEnum::ABSENT;
                }
            }

            if ($live) {
                $class->live_status = 1;
                $class->status = beautify_slug(StatusEnum::ONGOING);
                $this->liveClass = $class;
            }
            if ($class->class_time->gt(Carbon::today($this->model->timezone)->subMinute()) && !$class->class_time->gt(Carbon::tomorrow($this->model->timezone))) {
                $this->todayClasses[] = $class;
            } elseif ($class->class_time->gt(Carbon::tomorrow($this->model->timezone)->subMinute())) {
                $this->nextClasses[] = $class;
            }
        }
    }

  


    public function GetStudentSlots()
    {
        $slotsofteacher = []; // all the slots on which teacher can take classes ;
        $bookedslotsofteacher = []; // all the consumed slots on which teacher is taking classes
        /* This function will return us free and booked slots of a teacher */
        foreach ($this->Model->teacher->availability->days as $key => $eachday) {
            $DayNo = $eachday->day_id; // i.e 0 for monday
            
            foreach ($eachday->slots as $key => $availabilty_slot) {
                $SlotId = $availabilty_slot->slot_id;  // which slot i.e from 0-48
                $slotsofteacher[] = $SlotId;    // add the one day teacher's slot to this array
                if (!empty($availabilty_slot->routine_class)) {

                    // it means this slot is being used in routine class
                    $bookedslotsofteacher[] = $SlotId;
                }
            }

            $this->TotalSlots->put($DayNo, $slotsofteacher);                         // adds all slots array to total slot slot collection
            $this->BookedSlots->put($DayNo, $bookedslotsofteacher);                  // adds booked slots array to booked slot collection
            $slotsofteacher = []; // make the array empty to add slots id of new days
            $bookedslotsofteacher = []; // make the array empty to add slots id of new days


        }

        $this->TotalSlots->each(function ($item, $key) {
            $this->FreeSlots->put($key, collect($item)->diff($this->BookedSlots[$key]));                 // makes a difference of total slots and the booked slots to make free slots
        });
    }


    public function GetTeacherCoordinatorSlots()
    {   
        
      
        $slotsofteacher = []; // all the slots on which teacher can take classes ;
        $bookedslotsofteacher = []; // all the consumed slots on which teacher is taking classes
        /* This function will return us free and booked slots of a teacher */
        foreach ($this->Model->Teacher[0]->availability->days as $key => $eachday) {
            $DayNo = $eachday->day_id; // i.e 0 for monday
            foreach ($eachday->slots as $key => $availabilty_slot) {
                $SlotId = $availabilty_slot->slot_id;
                $slotsofteacher[] = $SlotId;    // add the one day teacher's slot to this array
                if (!empty($availabilty_slot->routine_class)) {

                    // it means this slot is being used in routine class
                    $bookedslotsofteacher[] = $SlotId;
                }
            }

            $this->TotalSlots->put($DayNo, $slotsofteacher);                         // adds all slots array to total slot slot collection
            $this->BookedSlots->put($DayNo, $bookedslotsofteacher);                  // adds booked slots array to booked slot collection
            $slotsofteacher = []; // make the array empty to add slots id of new days
            $bookedslotsofteacher = []; // make the array empty to add slots id of new days


        }

        $this->TotalSlots->each(function ($item, $key) {
            $this->FreeSlots->put($key, collect($item)->diff($this->BookedSlots[$key]));                 // makes a difference of total slots and the booked slots to make free slots
        });
    }

    
    public function GetTeacherSlots(){

        // this functiion is for teacher
        $slotsofteacher = []; // all the slots on which teacher can take classes ;
        $bookedslotsofteacher = []; // all the consumed slots on which teacher is taking classes
        /* This function will return us free and booked slots of a teacher */
        foreach ($this->Model->availability->days as $key => $eachday) {
            $DayNo = $eachday->day_id; // i.e 1 for monday
            foreach ($eachday->slots as $key => $availabilty_slot) {
                $SlotId = $availabilty_slot->slot_id;
                $slotsofteacher[] = $SlotId;    // add the one day teacher's slot to this array
                if (!empty($availabilty_slot->routine_class)) {

                    // it means this slot is being used in routine class
                    $bookedslotsofteacher[] = $SlotId;
                }
            }

            $this->TotalSlots->put($DayNo, $slotsofteacher);                         // adds all slots array to total slot slot collection
            $this->BookedSlots->put($DayNo, $bookedslotsofteacher);                  // adds booked slots array to booked slot collection
            $slotsofteacher = []; // make the array empty to add slots id of new days
            $bookedslotsofteacher = []; // make the array empty to add slots id of new days


        }

        $this->TotalSlots->each(function ($item, $key) {
            $this->FreeSlots->put($key, collect($item)->diff($this->BookedSlots[$key]));                 // makes a difference of total slots and the booked slots to make free slots
        });
    }

    public function TeacherSlots(){

        //this function is for teacher coordinator 

        $slotsofteacher = []; // all the slots on which teacher can take classes ;
        $bookedslotsofteacher = []; // all the consumed slots on which teacher is taking classes
        /* This function will return us free and booked slots of a teacher */
        foreach ($this->Model->teacher[0]->availability->days as $key => $eachday) {
            $DayNo = $eachday->day_id; // i.e 1 for monday
            foreach ($eachday->slots as $key => $availabilty_slot) {
                $SlotId = $availabilty_slot->slot_id;
                $slotsofteacher[] = $SlotId;    // add the one day teacher's slot to this array
                if (!empty($availabilty_slot->routine_class)) {

                    // it means this slot is being used in routine class
                    $bookedslotsofteacher[] = $SlotId;
                }
            }

            $this->TotalSlots->put($DayNo, $slotsofteacher);                         // adds all slots array to total slot slot collection
            $this->BookedSlots->put($DayNo, $bookedslotsofteacher);                  // adds booked slots array to booked slot collection
            $slotsofteacher = []; // make the array empty to add slots id of new days
            $bookedslotsofteacher = []; // make the array empty to add slots id of new days


        }

        $this->TotalSlots->each(function ($item, $key) {
            $this->FreeSlots->put($key, collect($item)->diff($this->BookedSlots[$key]));                 // makes a difference of total slots and the booked slots to make free slots
        });
    }

    public function MakeTeacherSlotForStudent()
    {
     
        //this function is for student // jab student ko reschedule request krni hoti tu woh teacher k timezone ko apny days main convert krta 
        try {


            // in this function we will convert teacher slots to student't time zone slot for a week 
            $week_days = get_current_week();  //here we will get all week days in an array
            foreach ($week_days as $key => $day) {
                if($this->TotalSlots->has($key))
                foreach ($this->TotalSlots[$key] as $k => $slot) {
                    $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($day, $slot, 'Y-m-d H:i:s'), $this->Model->timezone, $this->Model->teacher->timezone);   // this converts a week day class to stuent's timezone date
                    // $what_key = array_search(str_replace('"', "", $this_class_time), $week_days); // it belongs to which date key for the user ; and str replace because of the value in " ".. array search return index if exist else false
                    // if (!is_null($what_key)) {
                      
                        /* here we are doing k incase week ka end banta sunday tu woh classs agr next week k monday ko chali jati tu woh is monday ko show krwa do q k hm pichly sunday ki b tu is monday ko dhikhany chah rhy .*/
                        $week_end_date=get_current_week()[6];  // get last sunday of the ongoing week 

                        if (Carbon::parse($this_class_time->format('y-m-d'))->gt($week_end_date->format('y-m-d'))) {
                            // agar class is week s bhr nikal gai 
                          $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($day->subDays(7), $slot, 'Y-m-d H:i:s'), $this->Model->timezone, $this->Model->teacher->timezone);   // agr bhr nikal gai tu isi week ki date main kr do 

                        }
                      
                            $array = [
                            'slot' => $slot,
                            'class_time' => Carbon::parse($this_class_time),
                            // 'teacher_day' => $what_key,
                            'status' =>  in_array($slot, $this->BookedSlots[$key]) ? 'booked' : 'free'

                        ];

                        $this->StudentTime->push($array);
                    // }

                    // $this->student_time->put($what_key, convertTimeToUSERzone(convert_slot_to_time_of_a_date($day,$slot,'Y-m-d H:i:s' ),$this->Model->timezone,$this->Model->teacher->timezone));
                }
            }
            $this->StudentTime = $this->StudentTime->groupBy(function ($item, $key) {
                return Carbon::parse($item['class_time'])->format('Y-m-d');
            });
            // $this->StudentTime = $this->StudentTime->groupBy('class_time');
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    public function MakeTeacherSlotForCoordinator()
    {
        //this function is for student // jab student ko reschedule request krni hoti tu woh teacher k timezone ko apny days main convert krta 
        try {


            // in this function we will convert teacher slots to student't time zone slot for a week 
            $week_days = get_current_week();  //here we will get all week days in an array
            foreach ($week_days as $key => $day) {
                if($this->TotalSlots->has($key))
                foreach ($this->TotalSlots[$key] as $k => $slot) {
                    $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($day, $slot, 'Y-m-d H:i:s'), $this->Model->Teacher[0]->timezone, $this->Model->Teacher[0]->timezone);   // this converts a week day class to stuent's timezone date
                    $what_key = array_search(str_replace('"', "", $this_class_time), $week_days); // it belongs to which date key for the user ; and str replace because of the value in " "
                    if (!is_null($what_key)) {

                        $array = [
                            'slot' => $slot,
                            'class_time' => Carbon::parse($this_class_time),
                            // 'teacher_day' => $day,
                            'student_time'=>convertTimeToUSERzone(Carbon::parse($this_class_time), $this->Model->Teacher[0]->Students[0]->timezone, $this->Model->Teacher[0]->timezone)->addWeeks()->format('l jS \\of F Y h:i:s A'),  //this is extra feature in teacher co ordinator that it has student time as well
                            'status' =>  in_array($slot, $this->BookedSlots[$key]) ? 'booked' : 'free'

                        ];
                        $this->CoordinatorSlots->push($array);
                    }

                    // $this->student_time->put($what_key, convertTimeToUSERzone(convert_slot_to_time_of_a_date($day,$slot,'Y-m-d H:i:s' ),$this->Model->timezone,$this->Model->teacher->timezone));
                }
            }
            $this->CoordinatorSlots = $this->CoordinatorSlots->groupBy(function ($item, $key) {
                return Carbon::parse($item['class_time'])->format('Y-m-d');
            });
            // $this->StudentTime = $this->StudentTime->groupBy('class_time');
        } catch (Exception $e) {
            Log::info($e);
        }
    }


    public function MakeTeacherSlotForStudentSales()
    {
     
        //this function is for student // jab student ko reschedule request krni hoti tu woh teacher k timezone ko apny days main convert krta 
        try {

          
                $d    = new DateTime($this->date);
              $day_id=get_date_from_day($d->format('l'));  //pass l for lion aphabet in format 
            // in this function we will convert teacher slots to student't time zone slot for a week 
          
                if($this->TotalSlots->has($day_id))
                foreach ($this->TotalSlots[$day_id] as $k => $slot) {
                    $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($this->date, $slot, 'Y-m-d H:i:s'), $this->student->timezone, $this->Model->timezone);   // this converts a week day class to stuent's timezone date

                    // $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($this->date, $slot, 'Y-m-d H:i:s'), $this->student->timezone) ;   // this converts a week day class to stuent's timezone date
                    // $what_key = array_search(str_replace('"', "", $this_class_time), $week_days); // it belongs to which date key for the user ; and str replace because of the value in " ".. array search return index if exist else false
                    // if (!is_null($what_key)) {
                      
                        /* here we are doing k incase week ka end banta sunday tu woh classs agr next week k monday ko chali jati tu woh is monday ko show krwa do q k hm pichly sunday ki b tu is monday ko dhikhany chah rhy .*/
                        $week_end_date=get_current_week()[6];  // get last sunday of the ongoing week 

                        // if (Carbon::parse($this_class_time->format('y-m-d'))->gt($week_end_date->format('y-m-d'))) {
                        //     // agar class is week s bhr nikal gai 
                        //   $this_class_time = convertTimeToUSERzone(convert_slot_to_time_of_a_date($this->date->subDays(7), $slot, 'Y-m-d H:i:s'), $this->student->timezone, );   // agr bhr nikal gai tu isi week ki date main kr do 

                        // }
                      
                            $array = [
                            'slot' => $slot,
                            'class_time' => Carbon::parse($this_class_time),
                            // 'teacher_day' => $what_key,
                            'status' =>  in_array($slot, $this->BookedSlots[$day_id]) ? 'booked' : 'free'

                        ];

                        $this->StudentTime->push($array);
                    // }

                    // $this->student_time->put($what_key, convertTimeToUSERzone(convert_slot_to_time_of_a_date($day,$slot,'Y-m-d H:i:s' ),$this->Model->timezone,$this->Model->teacher->timezone));
                }
            
            $this->StudentTime = $this->StudentTime->groupBy(function ($item, $key) {
                return Carbon::parse($item['class_time'])->format('Y-m-d');
            });
            // $this->StudentTime = $this->StudentTime->groupBy('class_time');
        } catch (Exception $e) {
            Log::info($e);
        }
    }
}
