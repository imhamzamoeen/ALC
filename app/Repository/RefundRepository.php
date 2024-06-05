<?php

namespace App\Repository;

use App\Classes\Enums\StatusEnum;
use App\Models\Notification;
use App\Models\RoutineClass;
use Stripe;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\TrialClass;
use App\Models\WeeklyClass;
use Auth;

class RefundRepository
{
    public function refund($request)
    {
        try{   
            // dd($request);         
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $charge = Subscription::where('user_id','=',$request->user_Id)->where('student_id','=',$request->student)->first();
      
           $pay =  $stripe->refunds->create([
                'charge' => $charge->payment_id,
                'amount' => $request->amount * 100
            ]);           
            $this->cancelSubscription($request);
            $this->StudentClass($request);
            return "success";
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong.' . $e );
        }
    }

    public function cancelSubscription($data)
    {
        try{
          $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
          $subscription = Subscription::where('student_id','=',$data->student)->first();
          $stripe->subscriptions->cancel(
            $subscription->sub_id,
            []
          );
          return "success";
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong.' . $e );
        }
    }

    public function StudentClass($data)
    {
        try{
            //remove classes
            $classes = RoutineClass::where('student_id','=',$data->student);
            $loopClasses = $classes->get();
            foreach($loopClasses as $key=>$value){
               $classes->where('student_id','=',$value->student_id)->first()->forceDelete();
            }
            // 
            $WeeklyClass = WeeklyClass::where('student_id','=',$value->student_id)->where('status','=','scheduled');
            $loopWeekly = $WeeklyClass->get();
            foreach($loopWeekly as $key=>$value){
                $loopWeekly->where('student_id','=',$value->student_id)->delete();
            }
            //student status upate
            $update = ['subscription_status' => StatusEnum::TrialSuccessful,
            'is_subscribed' => 0];   
            Student::where('id','=',$data->student)->update($update);  
            //subscription cacncel 
            Subscription::where('student_id','=',$data->student)->first()->forceDelete(); 
            //notification delete
            $notification = Notification::where('student_id','=',$data->student);
            $loopNotif = $notification->get();
            foreach($loopNotif as $key=>$value){
                $notification->where('student_id','=',$value->student_id)->first()->forceDelete();
            }
            return "success";
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong.' . $e );
        }
    }
}