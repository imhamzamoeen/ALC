<?php

namespace App\Console;

use App\Console\Commands\createNewWeeklyClasses;
use App\Console\Commands\DueNotifications;
use App\Console\Commands\UpdateCustomerForUpcomingClass;
use App\Jobs\SendJobErrorMailJob;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateCustomerForUpcomingClass::class,
        createNewWeeklyClasses::class,
        DueNotifications::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {



        $schedule->command('logcleaner:run')->daily()->at('01:00');     // to delete log files daily


        $schedule->command('Remove15Min:Command')->daily()->onFailure(function (Stringable $output) {

            // this on failure only works if there is no try catch in handle function
            SendJobErrorMailJob::dispatch([
                'function' => 'Remove15Min:Command issue detected',
                'message' => $output,
            ]);
        });

        $schedule->command('command:UpdateUnattended')->everyThirtyMinutes()->onFailure(function (Stringable $output) {

            // this on failure only works if there is no try catch in handle function
            SendJobErrorMailJob::dispatch([
                'function' => 'command:UpdateUnattended issue detected',
                'message' => $output,
            ]);
        });

        $schedule->command('partipantcheck:command')->everyFiveMinutes()->onFailure(function (Stringable $output) {

            // this on failure only works if there is no try catch in handle function
            SendJobErrorMailJob::dispatch([
                'function' => 'partipantcheck:command issue detected',
                'message' => $output,
            ]);
        });

        $schedule->command('Notification:Clear')->daily()->onFailure(function (Stringable $output) {

            // this on failure only works if there is no try catch in handle function
            SendJobErrorMailJob::dispatch([
                'function' => 'Notification:Clear issue detected',
                'message' => $output,
            ]);
        });



        $schedule->command('TwoMinBefore:Command')->everyMinute()->onFailure(function (Stringable $output) {

            // this on failure only works if there is no try catch in handle function
            SendJobErrorMailJob::dispatch([
                'function' => 'TwoMinBefore:Command issue detected',
                'message' => $output,
            ]);
        });

        $schedule->command('JoinClass:Notification')->everyFifteenMinutes()->onFailure(function (Stringable $output) {
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'JoinClass:Notification Command',
                'message' => $output,
            ]);
        });

        $schedule->command('DailyClass:Command')->dailyAt("00:03")->onFailure(function (Stringable $output) {  // q k classes b 12 bjy banti and mail b 12 bnjy send hoti tu thora delay rkha
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'JoinClass:Notification Command',
                'message' => $output,
            ]);
        });
        $schedule->command('push_updates_for_upcoming_classes')->everyThreeMinutes();
        //  $schedule->command('create_weekly_classes')->dailyAt('00:00');
        $schedule->command('create_weekly_classes')->twiceDaily(1, 13)->onFailure(function (Stringable $output) {
            // the create weekly classes command executed successfully
            SendJobErrorMailJob::dispatch([
                'function' => 'create_weekly_classes',
                'message' => $output,
            ]);
        });
        $schedule->command('zoom:recording')->daily()->onFailure(function (Stringable $output) {
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'zoom recording Command',
                'message' => $output,
            ]);
        });
        $schedule->command('command:NotificationFilter')->daily()->onFailure(function (Stringable $output) {
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'Notification Filter Command',
                'message' => $output,
            ]);
        });

        $schedule->command('subscription_expire')->daily()->onFailure(function (Stringable $output) {
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'Subscription Expired Command',
                'message' => $output,
            ]);
        });

        $schedule->command('log_clear')->daily()->onFailure(function (Stringable $output) {
            // The NotificationFilter command failed
            SendJobErrorMailJob::dispatch([
                'function' => 'Log File Command',
                'message' => $output,
            ]);
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
