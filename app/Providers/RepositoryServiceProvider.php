<?php

namespace App\Providers;

use App\Repository\AvailabilityRepositoryInterface;
use App\Repository\CourseRepositoryInterface;
use App\Repository\TrialClassRepositoryInterface;
use App\Repository\TrialRequestRepositoryInterface;
use App\Repository\Eloquent\AvailabilityRepository;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CourseRepository;
use App\Repository\Eloquent\TrialClassRepository;
use App\Repository\Eloquent\TrialRequestRepository;
use App\Repository\Eloquent\LibraryFilesRepository;
use App\Repository\Eloquent\SharedLibraryRepository;
use App\Repository\Eloquent\SettingRepository;
use App\Repository\Eloquent\StudentRepository;
use App\Repository\Eloquent\SubscriptionPlanRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\LibraryFilesRepositoryInterface;
use App\Repository\SharedLibraryRepositoryInterface;
use App\Repository\SettingRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use App\Repository\SubscriptionPlanRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(TrialRequestRepositoryInterface::class, TrialRequestRepository::class);
        $this->app->bind(TrialClassRepositoryInterface::class, TrialClassRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(SubscriptionPlanRepositoryInterface::class, SubscriptionPlanRepository::class);
        $this->app->bind(SharedLibraryRepositoryInterface::class, SharedLibraryRepository::class);
        $this->app->bind(LibraryFilesRepositoryInterface::class, LibraryFilesRepository::class);
        $this->app->bind(AvailabilityRepositoryInterface::class, AvailabilityRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
