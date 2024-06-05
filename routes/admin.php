<?php

use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your admin panel. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/login', 'DashboardController@login')->name('login');

Route::group(['middleware' => ['userType:' . UserTypesEnum::Admin . ',' . UserTypesEnum::CustomerSupport . ',' . UserTypesEnum::TC, 'auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/', 'DashboardController@index');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        $controller = 'UsersController';
        Route::get('/', $controller . '@index')->name('list')->middleware('auth');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{user}', $controller . '@details')->name('view');
        Route::get('/edit/{id}', $controller . '@edit')->name('edit');
        Route::get('/detail/{id}', $controller . '@detailProfile')->name('details');        
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        Route::post('/update', $controller . '@update')->name('update');
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
        Route::post('/refund', $controller . '@refundPayment')->name('refund');
        Route::post('/getStudentPrice',$controller . '@getStudentPrice')->name('getStudentPrice');
        

        Route::group(['prefix' => 'teacher', 'as' => 'teacher.'], function () {
            $controller = 'TeachersController';
            Route::post('/add_availability', $controller . '@addAvailability')->name('addAvailability');
            Route::post('/assign_courses/{user}', $controller . '@assignCourses')->name('assignCourses');
            Route::post('/assign_coordinator/{user}', $controller . '@assignCoordinator')->name('assignCoordinator');
            Route::post('/assign_library/{user}', $controller . '@assignLibrary')->name('assignLibrary');
        });

        Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
            $controller = 'CustomersController';
            Route::get('/reset/pin/{user}', $controller . '@sendResetPinNotification')->name('resetPin');
        });

        Route::group(['prefix' => 'teacher-coordinator', 'as' => 'teacher-coordinator.'], function () {
            $controller = 'TeacherCoordinatorController';
            Route::post('add_availability', $controller . '@addAvailability')->name('addAvailability');
        });
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        $controller = 'RolesController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{id}', $controller . '@show')->name('view');
        /*Route::get('/edit/{id}',$controller.'@edit')->name('edit');*/
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        Route::get('/assign/{id}', $controller . '@assign')->name('assign');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        /*Route::post('/update/{id}',$controller.'@update')->name('update');*/
        Route::post('/assign/{id}', $controller . '@assignPermissions')->name('assign_permissions');
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
    });

    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
        $controller = 'PermissionsController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{id}', $controller . '@view')->name('view');
        /*Route::get('/edit/{id}',$controller.'@edit')->name('edit');*/
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        /*Route::post('/update/{id}',$controller.'@update')->name('update');*/
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
    });

    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
        $controller = 'CoursesController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{id}', $controller . '@edit')->name('view');
        Route::get('/edit/{id}', $controller . '@edit')->name('edit');
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        Route::post('/update/{id}', $controller . '@update')->name('update');
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        $controller = 'SettingsController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/edit/{id}', $controller . '@edit')->name('edit');
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        Route::post('/update', $controller . '@update')->name('update');
    });

    Route::group(['prefix' => 'subscription-plans', 'as' => 'subscription-plans.'], function () {
        $controller = 'SubscriptionsController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{id}', $controller . '@view')->name('view');
        Route::get('/edit/{id}', $controller . '@edit')->name('edit');
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        Route::post('/update/{id}', $controller . '@update')->name('update');
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
    });

    Route::group(['prefix' => 'shared-library', 'as' => 'shared-library.'], function () {
        $controller = 'SharedLibraryController';
        Route::get('/', $controller . '@index')->name('list');
        Route::get('/{folder}/files', $controller . '@folderFiles')->name('folderFiles');
        Route::get('/create', $controller . '@create')->name('add');
        Route::get('/view/{id}', $controller . '@view')->name('view');
        Route::get('/edit/{id}', $controller . '@edit')->name('edit');
        Route::get('/destroy/{id}', $controller . '@destroy')->name('delete');
        Route::get('/file/destroy/{id}', $controller . '@destroyFile')->name('deleteFile');
        /*POST ROUTE*/
        Route::post('/store', $controller . '@store')->name('save');
        Route::post('/add/folder', $controller . '@addFolder')->name('addFolder');
        Route::post('{folder}/add/file', $controller . '@addFile')->name('addFile');
        Route::post('/update', $controller . '@update')->name('update');
        Route::post('/update/file', $controller . '@updateFile')->name('updateFile');
        Route::post('/bulk-action', $controller . '@bulkAction')->name('bulkAction');
        Route::post('/bulk-action/files', $controller . '@bulkFileAction')->name('bulkFileAction');

        Route::post('/assign-teacher/{library}', $controller . '@assignTeachers')->name('assignTeachers');
    });

    Route::group(['prefix' => 'class-schedule', 'as' => 'class-schedule.'], function () {
        $controller = 'ClassScheduleController';
        Route::get('/', $controller . '@view')->name('view');
    });
});
