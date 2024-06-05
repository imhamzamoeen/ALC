<?php

namespace App\Http\Controllers\Customers;

use App\Classes\AlertMessages;
use App\Classes\AlQuranConfig;
use App\Classes\Enums\StatusEnum;
use App\Http\Controllers\AttendanceMainController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ChangesRequestRequest;
use App\Http\Requests\Customer\HelpAndSupportRequest;
use App\Http\Requests\Customer\UpdateProfileRequest;
use App\Http\Requests\GetAttendanceRequest;
use App\Jobs\CreateNewClassesOfStudent;
use App\Jobs\SendChangeRequestJob;
use App\Models\ChangesRequest;
use App\Models\Course;
use App\Models\TrialClass;
use App\Models\TrialReview;
use App\Models\RoutineClass;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Models\Subscription;
use App\Models\WeeklyClass;
use App\Notifications\NotifyCustomerWithResetPin;
use App\Repository\CourseRepositoryInterface;
use App\Repository\TrialRequestRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\SubscriptionRepository;
use App\Services\JsonResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stripe;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class ConsoleController extends Controller
{
    private $courseRepository;
    private $studentRepository;
    private $trialRequestRepository;
    private $userRepository;
    private $details;


    public function __construct(
        CourseRepositoryInterface      $courseRepository,
        StudentRepositoryInterface     $studentRepository,
        TrialRequestRepositoryInterface $trialRequestRepository,
        UserRepositoryInterface        $userRepository

    ) {
        $this->courseRepository = $courseRepository;
        $this->studentRepository = $studentRepository;
        $this->trialRequestRepository = $trialRequestRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        //$user = $this->userRepository->findById(2, ['profiles']);
        // $user = User::where('id', 2)->with(['profiles'])->first();
        //dd($user);
        $user = auth()->user();
        $courses = $this->courseRepository->activeCourses(['creator']);

        return view('front.customer.console', compact('user', 'courses'));
    }

    public function addStudent(Request $request)
    {
        $input = $request->all();
        /*Validating Inputs*/
        Validator::make($input, [
            'name'          => ['required'],
            'gender'        => ['required'],
            'age'           => ['required'],
            'course_id'        => ['required'],
            'custom_course' => ['required_if:course,==,0', 'nullable'],
            'days'          => ['required'],
            'shift_id'         => ['required'],
            'timezone'      => ['required']
        ])->validate();

        /*Creating a new custom course instance*/
        if ($input['course_id'] == 0) {
            $request->course_id = $this->courseRepository->createCustom($request->only(['custom_course']))->id;
        }
        /*Creating a new student instance*/
        $studentData = array_merge($request->only(['name', 'gender', 'age', 'course_id', 'shift_id', 'timezone']), ['user_id' => auth()->user()->id]);
        $student = $this->studentRepository->create($studentData);

        /*Creating a trial request from the student*/
        $trialRequest = $this->trialRequestRepository->createTrialAndNotify($student, $input['days']);


        return redirect()->back();
    }
    public function edit($locale, Student $student, Request $request, SubscriptionRepository $repository)
    {
        $content = new GetAttendanceRequest();
        $content->asking_id = auth()->id();
        $content->student_id = $student->id;
        $data = ((new AttendanceMainController)->GetAttendance($content));
        $data = $data->getOriginalContent()['response'];
        $chart_data = WeeklyClass::select('student_status', DB::raw('count(*) as count'))->where('student_id', $student->id)->groupBy('student_status')->get()->groupBy('student_status');
        $subscription = Subscription::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->first();
        //get customer payment method
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customerID = $repository->getCustomerID($stripe);
        if ($customerID != "false") {
            $card = $stripe->customers->allPaymentMethods(
                $customerID['id'],
                ['type' => 'card']
            );
            $cardInfo = $card['data'][0]['card'];
        } else {
            $cardInfo = "False";
        }
        return view('front.customer.profile', compact('student', 'data', 'chart_data', 'subscription', 'cardInfo'));
    }
    public function viewBasicInfo()
    {
        return view('front.customer.sub_pages.basicInfo');
    }
    public function subscriptionDetails($locale, Student $student)
    {
        $student = $student->load([ 'latestChangeRequestOfTeacher',
        'latestChangeRequestOfCourse']);

        $subscription = Subscription::where('user_id', '=', Auth::user()->id)->where('student_id', '=', $student->id)->orderBy('id', 'desc')->first();
        return view('front.customer.sub_pages.subscriptions', compact('student', 'subscription'));
    }
    public function settings()
    {
        $User = auth()->user();

        return view('front.customer.sub_pages.settings', compact('User'));
    }
    public function viewBillHistory()
    {
        $subscription = Subscription::where('user_id', '=', Auth::user()->id)->with('user')->get();

        return view('front.customer.sub_pages.billing_history', compact('subscription'));
    }
    public function paymentMethod(SubscriptionRepository $repository)
    {
        $subscription = Subscription::where('user_id', '=', Auth::user()->id)->skip(0)->take(3)->orderBy('id', 'desc')->with('user')->with('student')->get();
        //get customer payment method
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customerID = $repository->getCustomerID($stripe, Auth::user()->email);

        if (Auth::user()->stripe_id != null) {
            $card = $stripe->customers->allPaymentMethods(
                Auth::user()->stripe_id,
                ['type' => 'card']
            );

            $cardInfo = $card['data'][0]['card'];
        } else {
            $cardInfo = "False";
        }

        return view('front.customer.sub_pages.payment_method', compact('subscription', 'cardInfo'));
    }
    public function helpSupport()
    {
        return view('front.customer.sub_pages.help_support');
    }
    public function changeSubscription($locale, Student $student, SubscriptionRepository $repository)
    {
        $student->load('routine_classes', 'subscription');
        $teacher =  $student->teacher;
        //get customer payment method
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customerID = $repository->getCustomerID($stripe, Auth::user()->email);

        if ($customerID != "false") {
            $card = $stripe->customers->allPaymentMethods(
                $customerID['id'],
                ['type' => 'card']
            );
            $cardInfo = $card['data'][0]['card'];
        } else {
            $cardInfo = "False";
        }
        $updateSubscription = true;
        return view('components.customer.change-subscription', compact('student', 'teacher', 'cardInfo', 'updateSubscription'));
    }
    public function viewRequest($locale, Student $student)
    {
        return view('front.customer.sub_pages.view_request_page', compact('student'));
    }
    public function viewVacationRequest()
    {
        return view('front.customer.components.vacation_request');
    }
    public function cancelSubscription()
    {
        return view('front.customer.components.cancel_subscription');
    }

    public function submitReview(Request $request)
    {

        $data = $request->validate([
            'trial_class_id' => ['required', 'numeric'],
            'communication' => ['required', 'numeric'],
            'teaching' => ['required', 'numeric'],
            'behaviour' => ['required', 'numeric'],
            'student_id'    => ['required', 'numeric']
        ]);

        try {
            DB::beginTransaction();
            $review = TrialReview::updateOrCreate(['trial_class_id' => $data['trial_class_id']], $data);
            DB::commit();

            $fillableView = view('front.customer.partials.buy-subscription-btn', ['student' => $request->student_id])->render();

            return response()->json(['fillableData' => $fillableView, 'status'  => 'success', 'message' => 'Review submitted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['fillableData' => '', 'status'  => 'error', 'message' => 'Something went wrong! Please try again.'], 500);
        }
    }

    public function requestTrialReschedule(Request $request)
    {
        $data = $request->validate([
            'trial_class_id' => ['required', 'numeric'],
            'student_id'    => ['required', 'numeric'],
            'reason'        => ['required', 'max:300']
        ]);
        try {
            DB::beginTransaction();
            $trialClass = TrialClass::find($data['trial_class_id']);
            $trialClass->update(['status' => StatusEnum::TrialRescheduled]);
            $trialClass->trialRequest->update(['status' => StatusEnum::TrialRescheduled, 'reason' => $data['reason']]);
            $trialClass->trialRequest->student->update(['subscription_status' => StatusEnum::TrialRescheduled]);
            DB::commit();

            $fillableView = '--';

            return response()->json(['fillableData' => $fillableView, 'status'  => 'success', 'message' => 'Request submitted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['fillableData' => '', 'status'  => 'error', 'message' => 'Something went wrong! Please try again.'], 500);
        }
    }

    public function setupPin(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'pin_1' => ['required', 'numeric'],
            'pin_2' => ['required', 'numeric'],
            'pin_3' => ['required', 'numeric'],
            'pin_4' => ['required', 'numeric'],
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => AlertMessages::VALIDATION_ERROR], 400);
        } else {
            $pin = (int)$data['pin_1'] . $data['pin_2'] . $data['pin_3'] . $data['pin_4'];
            $pin = Hash::make($pin);

            $update = Auth::user()->update(['customer_pin' => $pin]);
            if ($update) {
                // if he has setup pin then uski wohi session mian b rkha do
                return response()->json(['status' => 'success', 'message' => AlertMessages::PIN_SETUP_SUCCESSFUL], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => AlertMessages::ERROR_500], 500);
            }
        }
    }

    public function checkPin(Request $request)
    {

        $data = $request->all();
        $validate = Validator::make($data, [
            'pin_1' => ['required', 'numeric'],
            'pin_2' => ['required', 'numeric'],
            'pin_3' => ['required', 'numeric'],
            'pin_4' => ['required', 'numeric'],
        ]);
        //dd($data);
        if ($validate->fails()) {
            return response()->json(['status' => 'error', 'message' => AlertMessages::VALIDATION_ERROR], 400);
        } else {
            $pin = (int)$data['pin_1'] . $data['pin_2'] . $data['pin_3'] . $data['pin_4'];

            if (Hash::check($pin, auth()->user()->customer_pin)) {
                session(['customer_pin' => true]);
                if ($request->stDashboard == "true") {
                    $data['student_id'] = $request->student_id;
                    $data['stDashboard'] = $request->stDashboard;
                } else {
                    $data['stDashboard'] = "false";
                }
                return response()->json(['status' => 'success', 'message' => AlertMessages::PIN_SUCCESSFUL, 'data' => $data], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => AlertMessages::PIN_INVALID], 403);
            }
        }
    }

    public function resetPin()
    {
        try {
            DB::beginTransaction();
            $digits = 4;
            $pin = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

            $user = Auth::user();
            $user->update(['customer_pin' => Hash::make($pin)]);
            DB::commit();

            $user->notify(new NotifyCustomerWithResetPin($user, $pin));

            return response()->json(['status' => 'success', 'message' => AlertMessages::PIN_RESET], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => AlertMessages::ERROR_500], 500);
        }
    }

    public function buySubscription($locale, Student $student, SubscriptionRepository $repository)
    {
        $student->load('subscription', 'routine_classes');

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $customerID = $repository->getCustomerID($stripe);

        if ($customerID != "false") {
            $card = $stripe->customers->allPaymentMethods(
                $customerID['id'],
                ['type' => 'card']
            );
            $cardInfo = $card['data'][0]['card'];
        } else {
            $cardInfo = "False";
        }
        $planPrice = $repository->planPrice($stripe, $student);

        if ($student->subscription_status != StatusEnum::TrialSuccessful && $student->subscription_status != StatusEnum::SubscriptionExtend && $student->subscription_status != StatusEnum::SubscriptionEnd) {
            return redirect()->back();
        }
        $Model =  Student::whereId($student->id)->with('teacher.availability.days.slots')->with('routine_classes')->with('subscription')->first();
        $slots = $Model->routine_classes->count();
        $subscription = Subscription::where('student_id', '=', $student->id)->first();

        return view('front.customer.subscription', compact('student', 'Model', 'slots', 'cardInfo', 'planPrice'));
    }

    public function joinClass()
    {
        return view('zoom.joinClass');
    }

    //stripe 
    public function stripe()
    {
        return view('front.customer.stripe');
    }

    public function stripePost(Request $request, SubscriptionRepository $repository)
    {
        DB::beginTransaction();
        try {

            $studentID = $request->student_id;
            $price = $request->total_price;
            $id = Auth::user()->id;

            //slots count
            if ($request->has('Extend_slots')) {
                $slots = $repository->studentSlot($studentID);
                $slotsCount = $request->Extend_slots;
            } else {
                $slots = explode(',', $request->slots[0]);
                $slotsCount = count($slots);
            }

            // $repository->stripeCreate($request);
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            if (Auth::user()->stripe_id == null) {
                // stripe customer create
                $customerinfo = $stripe->customers->create([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'description' => Auth::user()->name . '  ' . "created as a customer.",
                ]);
                //payment method create
                $response = $stripe->customers->createSource(
                    $customerinfo['id'],
                    ['source' => $request->stripeToken]
                );
                $data['stripe_id'] = $customerinfo['id'];
                User::where('id', '=', Auth::user()->id)->update($data);
            } else {
                $customerinfo = $stripe->customers->retrieve(
                    Auth::user()->stripe_id,
                    []
                );
            }

            if ($request->has('card_tho')) {
                //payment card
                $response = $repository->getPaymentCard($stripe, $customerinfo);
            }

            //Retrive plan
            $plan = $repository->retrivePlan($slotsCount);


            if ($request->change_subscription == "true") {
                //update package                
                $subscription_update = $repository->changeSubscription($stripe, $studentID, $plan['id']);
            } else {
                //update subscription
                $subscription_update = $repository->checkSubscription($studentID, $plan['id']);
            }


            //transaction
            $response = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $response = Stripe\Charge::create([
                "amount" => $price * 100,
                "currency" => "usd",
                "customer" => $customerinfo,
                // "source" => $request->stripeToken,
                "description" => "This payment is for testing purpose",
            ]);

            $payment_name = 'Stripe';

            if ($subscription_update == "false") {
                //Recurring payment
                $subscription = $stripe->subscriptions->create([
                    'customer' => $customerinfo['id'],
                    'items' => [
                        [
                            'price' => $plan['id'],
                            'quantity' => 1,
                        ],
                    ],
                ]);
            } else {
                $subscription['id'] = $subscription_update['id'];
            }

            //schedule classes
            $repository->classSchedule($slots, $studentID);

            //save subscription into database
            $repository->saveSubscription($response, $price, $studentID, $request, $payment_name, $plan['id'], $customerinfo['id'], $subscription['id']);

            //Mail to parent
            $repository->sendMailToParent($response, $price, $studentID, $request, $payment_name, $customerinfo['id']);

            DB::commit();
            return redirect()
                ->route('customer.console', [app()->getLocale()])
                ->with('success', 'Transaction complete.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong.' . $e->getMessage())->withInput($request->all());
        }
    }

    //paypal test view
    public function paypal()
    {
        return view('front.customer.paypal');
    }

    //redirect to paypal link
    public function paypalPost(Request $request)
    {

        if (!$request->has('slots')) {
            return redirect()
                ->route('customer.buySubscription', ['student' => $request->student_id, app()->getLocale()])
                ->with('error', "Please select atleast one slot.");
        }
        $request->session()->put('student_id', $request->student_id);
        $request->session()->put('slots', $request->slots);
        $request->session()->put('price', $request->total_price);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $price = $request->total_price;
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" =>  $price,
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('customer.paypal.success', [app()->getLocale()]),
                "cancel_url" => route('customer.paypal.cancel', [app()->getLocale()]),
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('customer.buySubscription', ['student' => $request->student_id, app()->getLocale()])
                ->with('error', 'Something went wrong.');
        } else {

            return redirect()
                ->route('customer.buySubscription', ['student' => $request->student_id, app()->getLocale()])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function cancel(Request $request)
    {
        $studentID = $request->session()->get('student_id');
        return redirect()
            ->route('customer.buySubscription', ['student' => $studentID, app()->getLocale()])
            ->with('error', "You have canceled the transaction.");
    }

    public function success(Request $request, SubscriptionRepository $repository)
    {
        //student ID
        $studentID = $request->session()->get('student_id');
        //selected solts 
        $slots = $request->session()->get('slots');
        //count slots
        $slotsCount = count($slots);
        //price
        $price = $request->session()->get('price');
        $payment_name = 'Paypal';
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        $plans = $provider->listPlans();
        $planID = $repository->retrivePlanPayPal($slotsCount);
        $response['plan_id'] = $planID;

        // dd($request,$response,$provider,$plans,$slots,$subscription);   

        //Status complete
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            //Recurring payment
            $repository->recurringPayment($provider, $response);

            //save subscription into database
            $repository->saveSubscription($response, $price, $studentID, $request, $payment_name, $planID);
            // $provider->activateSubscription($response['plan_id'], 'activate the subscription');

            //Mail to parent
            $repository->sendMailToParent($response, $price, $studentID, $request, $payment_name);

            //schedule classes
            $res = $repository->classSchedule($slots, $studentID);
            // Error occur during schedule classes
            ($res == "error") ? $this->errorClassSchedule($request) : true;

            //Expire session 
            $request->session()->forget('student_id');
            $request->session()->forget('slots');
            $request->session()->forget('price');

            return redirect()
                ->route('customer.console', [app()->getLocale()])
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('customer.buySubscription', ['student' => $studentID, app()->getLocale()])
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    //
    public static function  errorClassSchedule($request)
    {
        $studentID = $request->session()->get('student_id');
        return redirect()
            ->route('customer.buySubscription', ['student' => $studentID, app()->getLocale()])
            ->with('error', 'Something went wrong in schedule classes.');
    }

    public function UpdateProfile(UpdateProfileRequest $request)
    {


        try {
            $update_data = array_filter($request->validated(), fn ($value) => !is_null($value) && $value !== '');
            DB::transaction(function () use ($update_data) {

                User::find(auth()->id())->update($update_data);
            });
            if ($update_data['pin_check'] == 1  &&  is_null(session('customer_pin'))) {
                // like he has turned it on 
                session(['customer_pin' => true]);
            }
            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong in updating profile.');
        }
    }

    public function submithelpSupport(HelpAndSupportRequest $request)
    {
        try {
            Mail::send('emails.partials.support.mail', $request->validated(), function ($message) {
                $message->to(config('emails.SALES_SUPPORT_EMAIL'), 'Support Mail')->subject('Alquran Classes Support Mail');
            });
            return back()->with('success', 'Mail Sent Successfully.');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong while seding mail.');
        }
    }

    //create payment card
    public function paymentMethodCreate(Request $request)
    {
        try {

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            if (Auth::user()->stripe_id == null) {
                // stripe customer create
                $customerinfo = $stripe->customers->create([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'description' => Auth::user()->name . '  ' . "created as a customer.",
                ]);
                //payment method create
                $stripe->customers->createSource(
                    $customerinfo['id'],
                    ['source' => $request->stripeToken]
                );
                $data['stripe_id'] = $customerinfo['id'];
                User::where('id', '=', Auth::user()->id)->update($data);
            } else {
                return redirect()->back()->with('error', 'Payment method already exist');
            }

            return redirect()->back()->with('success', 'Payment method created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.' . $e->getMessage())->withInput($request->all());
        }
    }

    //update payment card
    public function paymentMethodUpdate(Request $request)
    {
        try {

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->allPaymentMethods(
                Auth::user()->stripe_id,
                ['type' => 'card']
            );
            $stripe->customers->deleteSource(
                Auth::user()->stripe_id,
                $customer['data'][0]['id'],
                []
            );

            $stripe->customers->createSource(
                Auth::user()->stripe_id,
                ['source' => $request->stripeToken]
            );

            return redirect()->back()->with('success', 'Payment method updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.' . $e->getMessage())->withInput($request->all());
        }
    }

    //discount apply
    public function checkDiscount(Request $request)
    {
        try {
            $discount = Setting::where('category', '=', 'discount')->where('key', '=', $request->discount)->where('status', '=', 'active')->select('value')->first();
            if ($discount) {
                return response()->json(['data' => $discount, 'success' => true]);
            } else {
                return response()->json(["data" => "error"]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.' . $e->getMessage())->withInput($request->all());
        }
    }


    /* 
    Change Request function is to apply for teacher and course change request  by the customer 
    */

    public function ChangeRequest(ChangesRequestRequest $request, Student $student)
    {
        try {
            $input_data = $request->validated();
            if ($request->filled('course_title')) {
                /* user has choosen a custom course */
                self::CreateNewCourse($input_data);
                $input_data = Arr::except($input_data, ['course_title', 'course_description']);
            }

            $student->ChangesRequest()->Create($input_data);

            SendChangeRequestJob::dispatch([
                'student_name' => $student->name,
                'package'=> $student->subscription,
                'user_name' => $student->user->name,
                'user_email' => $student->user->email,
                'change_type' => $request->change_type,
                'request_date'=>now(),
            ]);

            return  JsonResponseService::JsonSuccess("Request For " . beautify_slug($request->change_type) . " submitted successfully", []);
        } catch (Exception $e) {
            return  JsonResponseService::getJsonException($e);
        }
    }


    private function CreateNewCourse(&$data)
    {
        try {
            DB::transaction(function () use (&$data) {
                $new_course = Course::firstOrCreate([
                    'title' => $data['course_title'],
                    'created_by' => auth()->id(),
                    'description' => $data['course_description'],
                    'is_custom' => 1
                ]);
                $data['course_id'] = $new_course->id;
            });
        } catch (Exception $e) {
            Log::info("Error in creating a cusotm corse in change course request ");
            Log::info($e->getMessage());
        }
    }
}
