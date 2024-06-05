<?php

namespace App\Console\Commands;

use App\Jobs\Classnotjoinedyetjob;
use App\Jobs\SendJobErrorMailJob;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParticipantNotJoinedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partipantcheck:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks whether teacher or student have joined class or not and if not then sends mail to coordinator';

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
        // Log::info("particiapnt check command");
            $classes = WeeklyClass::where([
                ['class_time', '=', Carbon::now('UTC')->subMinutes(5)->format('Y-m-d H:i:00')], // woh classes jis time main s 15 min nikal gaye 
            ])
            ->where(function ($query) {
                $query->where('teacher_presence',false)
                      ->orWhere('student_presence',false);
            })
            ->with(['Teacher.Teacher_Coordinator' => function ($query) {
            }, 'Student'])->get();
    

            foreach ($classes as $key => $class) {
                Log::info("someone has not joined");
                Classnotjoinedyetjob::dispatch($class->Teacher->Teacher_Coordinator,$class);
               
            }

        } catch (Exception $e) {

            Log::info("Particpiant not joined  Job Failed");
            Log::error($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Participant not joined issue detected',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
