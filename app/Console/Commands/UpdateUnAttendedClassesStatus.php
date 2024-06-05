<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Models\WeeklyClass;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUnAttendedClassesStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateUnattended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will update the status to unattended of the classes that are not attended by teacher or student';

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
       try{

                DB::transaction(function () {
                    WeeklyClass::where('class_time','<=',now()->subMinutes(30))->where(function ($query)  {
                        $query->where('teacher_presence',0)
                              ->Where('student_presence', 0);
                })->update([
                    'status'=>'unattended',
                ]);
                    });

       }
     catch (Exception    $e) {
        Log::info('Class stutus of old classes failed ');
        Log::debug($e->getMessage());
        SendJobErrorMailJob::dispatch([
            'function' => 'Class stutus of old classes failed Cron job error',
            'message' => $e->getMessage(),
        ]);
    }
    }
}
