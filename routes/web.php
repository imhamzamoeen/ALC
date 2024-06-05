<?php

use App\Classes\Enums\StatusEnum;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Classes\Enums\UserTypesEnum;
use App\Http\Controllers\AttendanceMainController;
use App\Http\Controllers\RescheuleRequestMainController;
use App\Http\Controllers\Student\MainController as StudentMainController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\MainController;
use App\Http\Controllers\Teacher\ResourceController;
use App\Http\Controllers\TeacherCoordinator\MainController as TeacherCoordinatorMainController;
use App\Http\Controllers\TeacherCoordinator\SharedLibraryController;
use App\Http\Controllers\VideoSDKController;
use App\Http\Controllers\ZoomWebHookController;
use App\Http\Controllers\PaypalWebHooksController;
use App\Http\Controllers\StripeWebHooksController;
use App\Jobs\Classnotjoinedyetjob;
use App\Jobs\SendDailyClassesMailJob;
use App\Mail\SalesSupportMail;
use App\Models\ChangesRequest;
use App\Models\Course;
use App\Models\TrialClass;
use App\Models\TrialRequest;
use App\Models\LibraryFile;
use App\Models\Notification as ModelsNotification;
// use App\Models\Notification;
use App\Models\RescheduleRequest;
use App\Models\Shareable;
use App\Models\SharedLibrary;
use App\Models\Shift;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Notifications\Send15minBeforeNotification;
use App\Services\NotificationFilterService;
use App\View\Components\TeacherCoordinator\TeacherComponent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Userland;

use Illuminate\Support\Facades\Notification;
use Webpatser\Uuid\Uuid;
use App\Events\ClearStudentClassesEvent;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::post('zoomevent',function(Request $request){
//     Log::info($request->all());
//     return response()->json(200);
// });

Route::post('zoomevent', [ZoomWebHookController::class, 'GetWebHooks']);
//paypal weebhooks
Route::post('paypalwebhooksevent', [PaypalWebHooksController::class, 'GetWebHooks']);
//stripe weebhooks
Route::post('stripewebhooksevent', [StripeWebHooksController::class, 'GetWebHooksEvents']);

Route::get('test', function () {

    try {

        //     
        
        
            $student=Student::find(4);
          $date=optional($student->latestChangeRequestOfCourse)->created_at;
     
          if (optional($date)->isBetween(
            Carbon::now()->startOfMonth(),
            Carbon::now()
        )) {
            echo 'The date was in the current month';
        }
          
        
     
        // return Student::find(2)->routine_classes()->WeeklyClass()->get();
        // Detach all roles from the user...
    
    } catch (Exception $e) {
        return $e->getMessage();
    }
});

// Route::get('check', [VideoSDKController::class, 'generateJWTKey']);

Route::get('/auth/redirect/{provider}', function ($provider) {
    return \Laravel\Socialite\Facades\Socialite::driver($provider)->redirect();
})->name('socialLogin');
Route::get('/auth/callback/{provider}', 'SocialLoginController@callback');
/*GET ROUTES*/
Route::group(['middleware' => 'setlocale', 'prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {

    //    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/', function () {
        return redirect()->route('register');
    })->name('home');
    //    Route::get('/', 'HomeController@index')->name('home');


    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        /* Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');*/

        /* Genereal routes for rescheule request that will be used by student and teacher for approing and disapproving rescheule request */
        Route::get('/{user}/{TrialClass:session_key}/join-trial-class', [VideoSDKController::class, 'index2'])->name('joinClassTrial')->middleware('zoomtrial');    /// for trial classs
        Route::get('/{user}/{WeeklyClass:session_key}/join-class', [VideoSDKController::class, 'index'])->name('joinClass')->middleware('zoom');        // for weekly_class
        Route::post('/ApproveRescheduleRequest', [RescheuleRequestMainController::class, 'ApproveRescheduleRequest'])->name('ApproveRescheduleRequest');
        Route::post('/DeclineRescheduleRequest', [RescheuleRequestMainController::class, 'DeclineRescheduleRequest'])->name('DeclineRescheduleRequest');
        /* Genereal routes to get Attendance  */
        Route::post('/GetAttendance', [AttendanceMainController::class, 'GetAttendance'])->name('GetAttendance');
        Route::post('/GetStudentStatsOfMonth', [AttendanceMainController::class, 'GetStudentStatsOfMonth'])->name('GetStudentStatsOfMonth');
        Route::post('/GetTeacherAttendance', [AttendanceMainController::class, 'GetTeacherAttendance'])->name('GetTeacherAttendance');
        Route::post('/GetStatsOfTeacherForMonth', [AttendanceMainController::class, 'GetStatsOfTeacherForMonth'])->name('GetStatsOfTeacherForMonth');


        Route::group(['middleware' => ['userType:' . UserTypesEnum::Customer], 'prefix' => UserTypesEnum::Customer, 'as' => UserTypesEnum::Customer . '.'], function () {
            Route::redirect('/', 'customer/dashboard');
            Route::get('/dashboard', 'Customers\DashboardController@index')->name('dashboard');


            Route::get('/complete-registration', 'Customers\DashboardController@completeRegistration')->name('completeRegistration');

            Route::group(['middleware' => ['parent']], function () {
                //stripe
                Route::get('/mail', function () {
                    return view('emails.partials.subcription.mail');
                })->name('mail');
                Route::get('/stripe', 'Customers\ConsoleController@stripe')->name('stripe');
                Route::post('/stripepost', 'Customers\ConsoleController@stripePost')->name('stripepost');

                //paypal
                // Route::get('/paypal', 'Customers\ConsoleController@paypal')->name('paypal');
                Route::post('/paypalpost', 'Customers\ConsoleController@paypalPost')->name('paypal.post');
                Route::get('/cancel', 'Customers\ConsoleController@cancel')->name('paypal.cancel');
                Route::get('/payment/success', 'Customers\ConsoleController@success')->name('paypal.success');

                //
                Route::get('/console', 'Customers\ConsoleController@index')->name('console');
                Route::get('/subscription/{student}', 'Customers\ConsoleController@buySubscription')->name('buySubscription');
                Route::get('/profile/{child}', 'Customers\ConsoleController@edit')->name('user.profile');
                Route::get('/basic-info', 'Customers\ConsoleController@viewBasicInfo')->name('viewBasicInfo');
                Route::get('/subscription-details/{child}', 'Customers\ConsoleController@subscriptionDetails')->name('subscriptionDetails');
                Route::get('/settings', 'Customers\ConsoleController@settings')->name('profile');
                Route::get('/paymentMethod', 'Customers\ConsoleController@paymentMethod')->name('paymentMethod');
                //create payment method                
                Route::post('/paymentMethodCreate', 'Customers\ConsoleController@paymentMethodCreate')->name('paymentMethodCreate');
                //change payment method
                Route::post('/paymentMethodUpdate', 'Customers\ConsoleController@paymentMethodUpdate')->name('paymentMethodUpdate');
                //check discount
                Route::post('/checkDiscount', 'Customers\ConsoleController@checkDiscount')->name('checkDiscount');

                Route::get('/helpSupport', 'Customers\ConsoleController@helpSupport')->name('helpSupport');
                Route::get('/bill-history', 'Customers\ConsoleController@viewBillHistory')->name('billHistory');
                Route::get('/change-subscription/{child}', 'Customers\ConsoleController@changeSubscription')->name('changeSubscription');

                Route::get('/view-request/{child}', 'Customers\ConsoleController@viewRequest')->name('viewRequest');
                Route::get('/cancel-subscription', 'Customers\ConsoleController@cancelSubscription')->name('cancelSubscription');
                Route::get('/vacation-request', 'Customers\ConsoleController@viewVacationRequest')->name('viewVacationRequest');
            });

            Route::group(['prefix' => 'student', 'as' => 'student.', 'middleware' => ['student']], function () {
                Route::get('/{student}/dashboard', 'Student\DashboardController@dashboard')->name('studentDashboard');
                Route::get('/{student}/component', 'Student\DashboardController@getComponent')->name('getComponent');
                Route::get('/vacation', 'Customers\DashboardController@vacations')->name('vacations');
                Route::get('/vacation-request', 'Student\DashboardController@vacationRequest')->name('vacationRequest');
                Route::get('/{student}/reschedule-request', 'Student\DashboardController@rescheduleRequest')->name('rescheduleRequest');
                Route::post('/RescheduleRequest', [StudentMainController::class, 'RescheduleRequest'])->name('RescheduleRequest');   //get teacher availability and show in modal
                Route::post('/MakeRescheduleRequest', [StudentMainController::class, 'MakeRescheduleRequest'])->name('MakeRescheduleRequest');
            });
        });

        Route::group(['middleware' => ['userType:' . UserTypesEnum::SalesSupport], 'prefix' => UserTypesEnum::SalesSupport, 'as' => UserTypesEnum::SalesSupport . '.'], function () {
            Route::get('/dashboard', 'SalesSupport\DashboardController@index')->name('dashboard');
            Route::get('/console', 'SalesSupport\DashboardController@index')->name('console');
            Route::get('/summary', 'SalesSupport\DashboardController@summary')->name('summary');
        });

        Route::group(['middleware' => ['userType:' . UserTypesEnum::Teacher], 'prefix' => UserTypesEnum::Teacher, 'as' => UserTypesEnum::Teacher . '.'], function () {
            Route::get('/dashboard', 'Teacher\DashboardController@index')->name('dashboard');
            // Route::get('/attendance', 'Teacher\DashboardController@attendance')->name('attendance');
            Route::get('/getComponent', [DashboardController::class, 'getComponent'])->name('getComponent');
            Route::post('/SearchResource', [ResourceController::class, 'SearchResource'])->name('SearchResource');
            Route::post('/GetStudentResource', [ResourceController::class, 'GetStudentResource'])->name('GetStudentResource');
            Route::post('/AssignResourceToStudent', [ResourceController::class, 'AssignResourceToStudent'])->name('AssignResourceToStudent');
            Route::post('/RemoveResourceToStudent', [ResourceController::class, 'RemoveResourceToStudent'])->name('RemoveResourceToStudent');
            Route::post('/RescheduleRequest', [MainController::class, 'RescheduleRequest'])->name('RescheduleRequest');   //get teacher availability and show in modal
            Route::post('/MakeRescheduleRequest', [MainController::class, 'MakeRescheduleRequest'])->name('MakeRescheduleRequest');
            Route::post('/GetTeacherStatsOfMonth', [DashboardController::class, 'GetTeacherStatsOfMonth'])->name('GetTeacherStatsOfMonth');
        });

        Route::group(['middleware' => ['userType:' . UserTypesEnum::TeacherCoordinator], 'prefix' => UserTypesEnum::TeacherCoordinator, 'as' => UserTypesEnum::TeacherCoordinator . '.'], function () {
            Route::get('/dashboard', 'TeacherCoordinator\DashboardController@index')->name('dashboard');
            Route::get('/getComponent', 'TeacherCoordinator\DashboardController@getComponent')->name('getComponent');
            Route::get('/ajaxpaginatesharedlibrary', 'TeacherCoordinator\DashboardController@ajaxpaginatesharedlibrary')->name('ajaxpaginatesharedlibrary');
            Route::post('/GetFolderFiles', 'TeacherCoordinator\DashboardController@GetFolderFiles')->name('GetFolderFiles');



            Route::post('/GetStudentOfTeacher', [TeacherCoordinatorMainController::class, 'GetStudentOfTeacher'])->name('GetStudentOfTeacher');
            Route::post('/RescheduleRequest', [TeacherCoordinatorMainController::class, 'RescheduleRequest'])->name('RescheduleRequest');   //get teacher availabiity in teacher coordintor  availability and show in modal
            Route::post('/MakeRescheduleRequest', [TeacherCoordinatorMainController::class, 'MakeRescheduleRequest'])->name('MakeRescheduleRequest');
            Route::post('/GetNotifcationForCoordinator', [TeacherCoordinatorMainController::class, 'GetNotifcationForCoordinator'])->name('GetNotifcationForCoordinator');

            Route::post('/CreateFolder', [SharedLibraryController::class, 'CreateFolder'])->name('CreateFolder');
            Route::post('/UpdateFolderName', [SharedLibraryController::class, 'UpdateFolderName'])->name('UpdateFolderName');
            Route::post('/UpdateFileName', [SharedLibraryController::class, 'UpdateFileName'])->name('UpdateFileName');
            Route::post('/DeleteFile', [SharedLibraryController::class, 'DeleteFile'])->name('DeleteFile');
            Route::post('/AddFileToFolder', [SharedLibraryController::class, 'AddFileToFolder'])->name('AddFileToFolder');
            Route::post('/DeleteSharedFile', [SharedLibraryController::class, 'DeleteSharedFile'])->name('DeleteSharedFile');
            Route::post('/AssignFolderToTeacher', [SharedLibraryController::class, 'AssignFolderToTeacher'])->name('AssignFolderToTeacher');




            Route::get('/chat', 'TeacherCoordinator\DashboardController@chat')->name('chat');

            // Route::get('/{coordinator}/component', 'TeacherCoordinator\DashboardController@getComponent')->name('getComponent');
        });
    });
});


/*POST ROUTES*/
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::group(['middleware' => ['userType:' . UserTypesEnum::Customer], 'prefix' => UserTypesEnum::Customer, 'as' => UserTypesEnum::Customer . '.'], function () {
        Route::post('/complete-registration', 'Customers\DashboardController@submitDetails')->name('submitDetails');
        Route::group(['middleware' => ['parent']], function () {
            Route::post('/UpdateProfile', 'Customers\ConsoleController@UpdateProfile')->name('UpdateProfile');
            Route::post('/add/student', 'Customers\ConsoleController@addStudent')->name('addStudent');
            Route::post('/trial/review', 'Customers\ConsoleController@submitReview')->name('submitReview');
            Route::post('/trial/reschedule', 'Customers\ConsoleController@requestTrialReschedule')->name('requestTrialReschedule');
            Route::post('/setup_pin', 'Customers\ConsoleController@setupPin')->name('setupPin');
            Route::post('/helpSupport', 'Customers\ConsoleController@submithelpSupport')->name('submithelpSupport');
            Route::post('/{child}/ChangeRequest', 'Customers\ConsoleController@ChangeRequest')->name('ChangeRequest');



            // Route::post('/save-schedule/{student}', 'Customers\ConsoleController@saveSchedule')->name('saveSchedule');
        });
        /*STUDENT POST ROUTES*/
        Route::group(['prefix' => 'student', 'as' => 'student.', 'middleware' => ['student']], function () {
            Route::post('/{student}/reschedule-request', 'Student\DashboardController@saveRescheduleRequest')->name('saveRescheduleRequest');
        });

        Route::post('/check_pin', 'Customers\ConsoleController@checkPin')->name('checkPin');
        Route::get('/reset_pin', 'Customers\ConsoleController@resetPin')->name('resetPin');
    });
    Route::group(['middleware' => ['userType:' . UserTypesEnum::SalesSupport], 'prefix' => UserTypesEnum::SalesSupport, 'as' => UserTypesEnum::SalesSupport . '.'], function () {
    });
});


Route::get('setLocale/{locale}', function ($locale) {
    if (array_key_exists($locale, \App\Classes\AlQuranConfig::Locales)) {
        \Illuminate\Support\Facades\Session::put('locale', $locale);
    }
    return redirect('/');
})->name('setLocale');


Route::get('/', function () {
    $locale = app()->getLocale();
    return redirect($locale);
});
