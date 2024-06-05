<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Jobs\TwominbeforeJob;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TwoMinBeforeClassCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TwoMinBefore:Command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be used to send joining link to teacher and student beofore class starting';

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
                ['class_time', '=', Carbon::now('UTC')->addMinutes(3)->format('Y-m-d H:i:00')], // woh classes jis k start main 3 min rehty 
            ])->with(['Teacher' => function ($query) {
            }, 'Student'])->get();

            foreach ($classes as $key => $class) {
                TwominbeforeJob::dispatch([$class->student->user, $class->teacher], $class);
            }
        } catch (Exception $e) {
            Log::info('zoom cloud recording command');
            Log::debug($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Two Min Before Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
