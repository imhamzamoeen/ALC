<?php

namespace App\Console\Commands;

use App\Jobs\Dispatch15MinBeforeMailNotificationJob;
use App\Jobs\SendJobErrorMailJob;
use App\Models\WeeklyClass;
use App\Notifications\Send15minBeforeNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class JoinClassNotificationJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'JoinClass:Notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to send a notification before 15 minutes of every class';

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

            $classes = WeeklyClass::where([
                ['class_time', '=', Carbon::now('UTC')->addMinutes(15)->format('Y-m-d H:i:00')], // woh classes jis k start main 15 min rehty 
                // ['class_time', '<=', Carbon::now('UTC')],
            ])->with(['Teacher' => function ($query) {
            }, 'Student'])->get();

            foreach ($classes as $key => $class) {
                Dispatch15MinBeforeMailNotificationJob::dispatch([$class->student->user, $class->teacher],$class);
               
            }

            // Send15minBeforeNotification::
        } catch (Exception $e) {
            Log::error("Generate Join class notification Error");
            Log::error($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'class notification before 15 min Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
