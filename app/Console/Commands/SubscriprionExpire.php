<?php

namespace App\Console\Commands;

use App\Classes\Enums\StatusEnum;
use App\Jobs\SendJobErrorMailJob;
use App\Models\RoutineClass;
use App\Models\WeeklyClass;
use App\Models\Student;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SubscriprionExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription_expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for expire subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Log::info("Expire Subscription");
            $subscription = Subscription::where('ends_at','=',Carbon::now()->format('Y-m-d'))->get();
            Log::info($subscription);
            if($subscription) {
            
                foreach ($subscription as $key=>$value) {
                
                    $student = Student::where('id','=',$value->student_id)->where('is_subscribed','=',2)->first();

                    if($student) {
                        $data['is_subscribed'] = 3;
                        $data['subscription_status'] = StatusEnum::SubscriptionEnd;
                        Student::where('id','=',$value->student_id)->update($data);
                        $routneClass = RoutineClass::where('student_id','=',$value->student_id)->get();  
                        foreach($routneClass as $key=>$value){
                            RoutineClass::where('student_id','=',$value->student_id)->delete();
                        }
                        $WeeklyClass = WeeklyClass::where('student_id','=',$value->student_id)->where('status','=','scheduled')->get();
                        foreach($WeeklyClass as $key=>$value){
                            WeeklyClass::where('student_id','=',$value->student_id)->delete();
                        }
                    } else {
                                            
                        $change['is_subscribed'] = 2;
                        $change['subscription_status'] = StatusEnum::SubscriptionExtend;
                        Student::where('id','=',$value->student_id)->where('is_subscribed','=',1)->update($change);
                        $data['ends_at'] = Carbon::now()->addWeeks(1)->format('Y-m-d');
                        Subscription::where('student_id','=',$value->student_id)->update($data);
                        
                    }
                }
                
            } 
            Log::info($subscription);
        } catch (Exception $e) {
            // DB::rollback();
            $this->info($e);
            Log::info($e);
            SendJobErrorMailJob::dispatch([
                'function' => 'Monthly Subcription error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
