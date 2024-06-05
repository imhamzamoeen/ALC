<?php

namespace App\Repository;

use Stripe;
use App\Models\Student;
use App\Models\RoutineClass;
use App\Models\WeeklyClass;
use DB;
use App\Classes\AlQuranConfig;
use App\Classes\Enums\StatusEnum;
use App\Jobs\CreateNewClassesOfStudent;
use Auth;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionRepository
{
    private $details;
    //Stripe integration
    public function stripeCreate($request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $request->price * 100,
            "customer" => $request->name,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "This payment is for testing purpose",
        ]);
        return "success";
    }

    //Create PaymentMethod
    public function createPaymentMethod($stripe, $request, $timestamp)
    {
        $stripesPay = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $request->number,
                'exp_month' => date('m', $timestamp),
                'exp_year' => date('Y', $timestamp),
                'cvc' => $request->cvc,
            ],
        ]);
        return $stripesPay;
    }

    //Attach payment
    public function attachPaymentMethod($stripe, $paymentMethodID, $customerCreateID)
    {
        $stripesAtach =  $stripe->paymentMethods->attach(
            $paymentMethodID,
            ['customer' => $customerCreateID]
        );
        return $stripesAtach;
    }
    //Retreive plan
    public function retrivePlan($slotsCount)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        if ($slotsCount == 1) {

            $stripe = $stripe->plans->retrieve(
                'price_1LpVAfGCjSuNUCyBQVNSYMu8',
                []
            );
        } elseif ($slotsCount == 2) {

            $stripe = $stripe->plans->retrieve(
                'price_1Lp7coGCjSuNUCyBg5I7fROF',
                []
            );
        } elseif ($slotsCount == 3) {
            $stripe = $stripe->plans->retrieve(
                'price_1Lp7d8GCjSuNUCyBjy2nHPcj',
                []
            );
        } elseif ($slotsCount == 4) {
            $stripe = $stripe->plans->retrieve(
                'price_1Lp7e1GCjSuNUCyBDgZIqD8q',
                []
            );
        } elseif ($slotsCount == 5) {
            $stripe = $stripe->plans->retrieve(
                'price_1LmB8fGCjSuNUCyBDdWe2PdV',
                []
            );
        } elseif ($slotsCount == 6) {
            $stripe = $stripe->plans->retrieve(
                'price_1LmB92GCjSuNUCyBD9m9zA29',
                []
            );
        }
        return $stripe;
    }

    //Recurring stripe
    public function subscribe_process($customer, $planID, $id)
    {
        try {
           
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $user = User::find($id);
            $stripe = $stripe->subscriptions->create([
                'customer' => $customer,
                'items' => [
                    ['price' => $planID],
                ],
            ]);
           
            return  $stripe;
        } catch (\Exception $ex) {
            return back()->with($ex->getMessage());
        }
    }


    //schedule class
    public function classSchedule($slots, $studentID)
    {
        try {
            $student = Student::find($studentID);
            $classes = array();

            if ($student->subscription_status == StatusEnum::TrialSuccessful || $student->subscription_status == StatusEnum::SubscriptionExtend  || $student->subscription_status == StatusEnum::SubscriptionEnd || $student->trialRequest->trialClass->trialReview) {
                foreach ($slots as $slot) {
                    if (!RoutineClass::where('teacher_id', $student->teacher_id)->where('slot_id', $slot)->exists()) {
                        $classes[] = [
                            'student_id' => $student->id,
                            'teacher_id' => $student->teacher_id,
                            'slot_id'    => $slot,
                            'class_link' => AlQuranConfig::DefaultZoomLink,
                            'status'     => StatusEnum::Active,
                            'created_at' => now()
                            /*todo:TEMPORARY ACTIVE Class STATUS TO OVERRIDE PAYMENT SECTION*/
                        ];
                    }
                }

                RoutineClass::insert($classes);
                $details = [
                    'student_id' => $student->id,
                    'teacher_id' => $student->teacher_id,
                ];
                Log::info("calling create class");
                CreateNewClassesOfStudent::dispatch($details);
                // dispatch(new CreateNewClassesOfStudent($details));   // to create classes of the new student  
                /*todo:TEMPORARY ACTIVE SUBSCRIPTION STATUS TO OVERRIDE PAYMENT SECTION*/
                $student->update(['subscription_status' => StatusEnum::SubscriptionActive, 'is_subscribed' => 1]);
                return "success";
            } else {

                return "error";
            }
        } catch (Exception $e) {
            Log::info("instant class creation is failed");
            Log::info($e->getMessage());
        }
    }

    //save in database
    public function saveSubscription($response, $price, $studentID, $request, $name, $planID = false, $customerinfo = false, $subscriptionID = false)
    {

        try {

            if ($name == "Stripe") {
                $payer_id = $customerinfo;
                $payment_name = "stripe";
            } else {
                $payer_id = $request->PayerID;
                $payment_name = "Paypal";
                $subscriptionID = null;
            }
            $this->details = [
                'user_id' => Auth::user()->id,
                'student_id' => $studentID,
                'payment_id' => $response['id'],
                'payer_id' => $payer_id,
                'price' => $price,
                'planID' => $planID,
                'sub_id' => $subscriptionID,
                'payment_status' => $response['status'],
                'quantity' => 1,
                'payment_name' => $payment_name,
                'start_at' => Carbon::now()->format('Y-m-d'),
                'ends_at' => Carbon::now()->addWeeks(4)->format('Y-m-d'),

            ];

            $check = Subscription::where('student_id', '=', $studentID)->first();


            if ($check) {
                Subscription::where('student_id', '=', $studentID)->update($this->details);
            } else {
                Subscription::create($this->details);
            }

            return 'success';
        } catch (\Exception $e) {
            return redirect()
                ->route('customer.buySubscription', ['student' => $studentID, app()->getLocale()])
                ->with('error', 'Something went wrong in subscription table.');
        }
    }

    //Recurrimg payment
    public function recurringPayment($provider, $response)
    {
        $subscription = $provider->createSubscription($response);

        if (isset($subscription['status']) && $subscription['status'] == 'APPROVAL_PENDING') {
            return "subscriped";
        } else {
            return "error";
        }
    }

    //Mail to customer
    public function sendMailToParent($response, $price, $studentID, $request, $name, $customerCreate = false)
    {
        $student = Student::where('id', '=', $studentID)->with('user')->first();
        if ($name == "Stripe") {
            $payer_info = '';
            $details = [
                'transaction_id' => $customerCreate,
                'status' => $response['status'],
                'payer_info' => $payer_info,
                'student_info' => $student,
                'price' => $price,
                'date' => Carbon::now()->format('Y-m-d'),
            ];
        } else {
            $payer_info = $response['payer'];
            $details = [
                'transaction_id' => $response['id'],
                'status' => $response['status'],
                'payer_info' => $payer_info,
                'student_info' => $student,
                'price' => $price,
                'date' => Carbon::now()->format('Y-m-d'),
            ];
        }


        Mail::send('emails.partials.subcription.mail', ["details" => $details], function ($m) use ($student) {
            $m->from("alquranclasses.mailer@gmail.com", config('app.name', 'APP Name'));
            $m->to($student->user->email, $student->user->name)->subject('Subscription - AlquranClasses!');
        });
    }

    public function retrivePlanPayPal($slotsCount)
    {
        if ($slotsCount == 1) {
            $planID = 'P-3BP45778N2073933KMMZLDTA';
        } elseif ($slotsCount == 2) {
            $planID = 'P-0MV351421K6883221MMZNUII';
        } elseif ($slotsCount == 3) {
            $planID = 'P-2FU97719GF454752YMMZNUWA';
        } elseif ($slotsCount == 4) {
            $planID = 'P-71J341580L539123WMMZNVLA';
        }

        return $planID;
    }

    //updatesubscription
    public function checkSubscription($studentID, $planID)
    {

        $student = Student::where('id', '=', $studentID)->with('subscription')->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        if ($student->is_subscribed == '2') {

            $subscription = $stripe->subscriptions->retrieve(
                $student->subscription->sub_id,
                []
            );

            // Change Plan
            $charge = $stripe->subscriptions->update($student->subscription->sub_id, [
                'proration_behavior' => 'none',
                'items' => [
                    [
                        'id' => $subscription->items->data[0]->id,
                        'price' => $planID,

                    ],
                ],

            ]);

            return $charge;
        } else {
            return "false";
        }
    }

    //update package
    public function changeSubscription($stripe, $studentID, $planID)
    {
        try {

            $student = Student::where('id', '=', $studentID)->with('subscription')->first();
            $subscription = $stripe->subscriptions->retrieve(
                $student->subscription->sub_id,
                []
            );

            $change = $stripe->subscriptions->update($student->subscription->sub_id, [
                'proration_behavior' => 'none',
                'items' => [
                    [
                        'id' => $subscription->items->data[0]->id,
                        'price' => $planID,

                    ],
                ],

            ]);

            $this->notificationSubscription("update", $studentID,$student->name);

            //previous classs
            $RoutineClass = RoutineClass::where('student_id', '=', $studentID)->get();
            if ($RoutineClass) {
                foreach ($RoutineClass as $routine) {
                    RoutineClass::where('id', '=', $routine->id)->delete();
                }
            }
            $WeeklyClass = WeeklyClass::where('student_id', '=', $studentID)->get();
            if ($WeeklyClass) {
                foreach ($WeeklyClass as $weekly) {
                    WeeklyClass::where('id', '=', $weekly->id)->delete();
                }
            }

            return $change;
        } catch (\Exception $e) {
            return redirect()
                ->route('customer.buySubscription', ['student' => $studentID, app()->getLocale()])
                ->with('error', 'Something went wrong in subscription table.');
        }
    }


    //Get customer
    public function getCustomerID($stripe)
    {
        try {
            if (Auth::user()->stripe_id != null) {

                $Getcustomer = $stripe->customers->retrieve(
                    Auth::user()->stripe_id,
                    []
                );
            } else {
                $Getcustomer = "false";
            }
            return $Getcustomer;
        } catch (\Exception $e) {
        }
    }

    public function getPaymentCard($stripe, $customer)
    {
        try {

            $card = $stripe->customers->allPaymentMethods(
                $customer['id'],
                ['type' => 'card']
            );
            $cardInfo = $card['data'][0]['card'];

            return $cardInfo;
        } catch (\Exception $e) {
            return $e;
        }
    }

    //get plan price
    public function planPrice($stripe, $planID)
    {
        try {
            $planPrice = $stripe->plans->retrieve(
                $planID->subscription->planID,
                []
            );
            $price = $planPrice['amount'] / 100;
            return $price;
        } catch (\Exception $e) {
            return $e;
        }
    }

    //get slots for classes
    public function studentSlot($studentID)
    {
        try {
            $slots = RoutineClass::where('student_id', '=', $studentID)->select('slot_id')->get();
            return $slots;
        } catch (\Exception $e) {
            return $e;
        }
    }

    //notification of subscription updated
    public function notificationSubscription($type, $studentID,$name)
    {
        try {
            if($type == "update"){
                $notification = [
                    'user_id'       => Auth::user()->id,
                    'studentName'    => $name,
                ];
                generate_notification_by_type(
                    'subscription_updated',
                    [
                        'user_id'       => Auth::user()->id,
                        'student_id'    => $studentID,
                        'remindable'    => 1,
                        'remind_at'     => Carbon::now(),
                    ],
                    [
                        'type' => 'subscription_updated',
                        'subscription_updated' => $notification,
                        'created_at' => now(),
                    ]
                );
            }
           return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
