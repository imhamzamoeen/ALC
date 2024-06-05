<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Stripe;
use App\Models\Student;
use App\Models\RoutineClass;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StripeWebHooksController extends Controller
{
    //
    public function GetWebHooksEvents(Request $request)
    {
        try {

            // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            // $events = $stripe->webhookEndpoints->retrieve(
            //     'we_1LndIHGCjSuNUCyBoQLjk5xD',
            //     []
            //   );

            //   Log::info($events);
            \Stripe\Stripe::setApiKey('sk_test_51LfcwpGCjSuNUCyBbxx01P4Oo0vGKzVW5GcPy3rJAX9xId2PbiVz8hp8oDn4dv9VzKaqIMTICN8YFt5cwX3cci7U00p6cZ8LBD');
            $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
            if ($request->header('stripe-signature') != null) {

                $payload = @file_get_contents('php://input');
                $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
                $event = null;
                // $event = \Stripe\Webhook::constructEvent(
                // $payload, $sig_header, $endpoint_secret );

                switch ($request['type']) {
                    case 'charge.succeeded':
                        $paymentIntent = $request['data']['object'];
                        
                        Log::info($paymentIntent);
                        break;
                    case 'charge.failed':
                        $paymentIntent = $request['data']['object'];
                        $this->failedSubscription($paymentIntent);
                        Log::info($paymentIntent);
                        break;
                    case 'customer.subscription.created':
                        $paymentIntent = $request['data']['object'];
                        $this->subscriptionCreate($paymentIntent);
                        Log::info($paymentIntent);
                        break;
                    case 'subscription_schedule.canceled':
                        $paymentIntent = $request['data']['object'];
                        $this->subscriptionCanceld($paymentIntent);
                        Log::info($paymentIntent);
                        break;
                    case 'customer.subscription.updated':
                        $paymentIntent = $request['data']['object'];
                        $this->subscriptionUpdated($paymentIntent);
                        Log::info($paymentIntent);
                        break;

                        // ... handle other event types
                    default:
                        Log::info($request['type']);
                }
                return response()->json(200);
            }
        } catch (\Exception $e) {
            Log::info("error in webhook");
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }
    //Failed transaction
    public function failedSubscription($paymentIntent)
    {
        try {
            //transaction failed change subscription status
            $changeStatus['payment_status'] = "Failed";
            $subscription = Subscription::where('sub_id', '=', $paymentIntent['id']);
            $subscription->update($changeStatus);

            $getStudentID = $subscription->first();
            //change status student
            $studentStatus['is_subscribed'] = "0";
            $studentStatus['subscription_status'] = "trial_successful";
            Student::where('id', '=', $getStudentID->student_id)->update($studentStatus);
            //If schedule then delete student class
            $class = RoutineClass::where('student_id', '=', $getStudentID->student_id)->get();
            foreach ($class as $value) {
                RoutineClass::where('id', '=', $value->id)->delete();
            }
            return true;
        } catch (\Exception $e) {

            Log::info('from verify method');
            Log::info($e);
            return $e->getMessage();
        }
    }
    // mahtab.ali@alquranclasses.com
    //subscription created
    public function subscriptionCreate($paymentIntent)
    {
        try {
            $subscription = Subscription::where('sub_id', '=', $paymentIntent['id'])->first();
            Log::info($subscription);
            $details['student'] = Student::where('id', '=', $subscription->student_id)->first();
            $details['user'] = User::where('id', '=', $subscription->user_id)->first();

            Mail::send('emails.partials.subcription.createdsubs', ["details" => $details], function ($m) {
                $m->from("stripe.mailer@gmail.com", config('app.name', 'APP Name'));
                $m->to("mahtab.ali@alquranclasses.com")->subject('Subscription - AlquranClasses!');
            });
            return true;
        } catch (\Exception $e) {

            Log::info('from verify method');
            Log::info($e);
            return $e->getMessage();
        }
    }
    //subscription update
    public function subscriptionUpdated($paymentIntent)
    {
        try {
            Log::info('update subscription', $paymentIntent);
            Log::info($paymentIntent['id']);
            $subscription = Subscription::where('sub_id', '=', $paymentIntent['id'])->first();
            Log::info($subscription);
            $details['student'] = Student::where('id', '=', $subscription->student_id)->first();
            $details['user'] = User::where('id', '=', $subscription->user_id)->first();
            //update subscription
            $data = [
                'start_at' => Carbon::now()->format('Y-m-d'),
                'ends_at' => Carbon::now()->addWeeks(4)->format('Y-m-d'),

            ];
            Subscription::where('sub_id', '=', $paymentIntent['id'])->update($data);
            //admin email
            Mail::send('emails.partials.subcription.updatesubs', ["details" => $details], function ($m) {
                $m->from("stripe.mailer@gmail.com", config('app.name', 'APP Name'));
                $m->to("mahtab.ali@alquranclasses.com")->subject('Subscription Updated- AlquranClasses!');
            });
            $email = $subscription->user->email;
            //customer email
            Mail::send('emails.partials.subcription.updatesubsCustomer', ["details" => $details], function ($m) use($email) {
                $m->from("stripe.mailer@gmail.com", config('app.name', 'APP Name'));
                $m->to($email)->subject('Subscription Updated - AlquranClasses!');
            });

            return true;
        } catch (\Exception $e) {

            Log::info('from verify method');
            Log::info($e);
            return $e->getMessage();
        }
    }

    //subscription cancled
    public function subscriptionCanceld($paymentIntent)
    {
        try {
            $subscription = Subscription::where('sub_id', '=', $paymentIntent['id'])->first();
            $details['student'] = Student::where('id', '=', $subscription->student_id)->first();
            $details['user'] = User::where('id', '=', $subscription->user_id)->first();

            Mail::send('emails.partials.subcription.canceledsubs', ["details" => $details], function ($m) {
                $m->from("stripe.mailer@gmail.com", config('app.name', 'APP Name'));
                $m->to("mahtab.ali@alquranclasses.com")->subject('Subscription - AlquranClasses!');
            });
            return true;
        } catch (\Exception $e) {

            Log::info('from verify method');
            Log::info($e);
            return $e->getMessage();
        }
    }
}
