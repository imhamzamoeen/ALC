<?php

namespace App\Providers;

use App\Classes\AlQuranConfig;
use App\Classes\Enums\UserTypesEnum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            foreach (AlQuranConfig::$Can_access_admin as $role) {
                Route::middleware('web')
                    ->prefix($role)->as($role . '.')
                    ->namespace($this->namespace . '\\Admin')    // that which namespace is used for that routes 
                    ->group(base_path('routes/admin.php'));
            }
            /*Route::middleware('web')
                ->prefix(UserTypesEnum::Admin)->as(UserTypesEnum::Admin.'.')
                ->namespace($this->namespace.'\\Admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix(UserTypesEnum::CustomerSupport)->as(UserTypesEnum::CustomerSupport.'.')
                ->namespace($this->namespace.'\\Admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix(UserTypesEnum::TeacherCoordinator)->as(UserTypesEnum::TeacherCoordinator.'.')
                ->namespace($this->namespace.'\\Admin')
                ->group(base_path('routes/admin.php'));*/


            Route::bind('child', function ($value) {
                return Student::where('user_id', auth()->id())->whereId($value)->firstOrFail();
            });

            /* the route binding only now works for route other than join classes  */
            Route::bind('user', function ($value) {
                if (\Illuminate\Support\Facades\Route::currentRouteName() != 'joinClassTrial' && \Illuminate\Support\Facades\Route::currentRouteName() != 'joinClass') {
                    $query = User::query();
                    $query->when(auth()->user()->user_type == UserTypesEnum::TC, function ($q) {
                        return $q->where('user_type', 'teacher');
                    });
                    $query->when(auth()->user()->user_type == UserTypesEnum::CustomerSupport, function ($q) {
                        return $q->where('user_type', 'customer');
                    });
                    return $query->whereId($value)->firstOrFail();
                }
                else {
                    return $value;
                }
            });
            /* this does not work for join class or dmeo class */
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
