<?php

namespace App\Console\Commands;

use App\Classes\Enums\StatusEnum;
use App\Jobs\SendJobErrorMailJob;
use App\Models\TrialClass;
use App\Notifications\RemindCustomerForUpcomingTrialClass;
use App\Repository\TrialClassRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateCustomerForUpcomingClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push_updates_for_upcoming_classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $minutes;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($minutes = 30)
    {
        parent::__construct();
        $this->minutes = $minutes;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $trial_classes = TrialClass::Has('trialRequest.student')->with(['trialRequest.student'])->where('status', StatusEnum::TrialScheduled)->orWhere('status', StatusEnum::TrialRescheduled)
                ->where('starts_at', '>=', Carbon::now()->subDay())
                ->where('starts_at', '<=', Carbon::now()->addDay())
                ->get();
            //dd($trial_classes);
            if ($trial_classes->count()) {
                foreach ($trial_classes as $trial_class) {
                    $student = $trial_class->trialRequest->student;
                    $customer = $student->user;
                    $studentTimezone = $student->timezone;

                    $studentTime = convertTimeToUSERzone(Carbon::now(), $studentTimezone);
                    $trialTime = convertTimeToUSERzone($trial_class->starts_at, $studentTimezone);

                    if ($studentTime < $trialTime) {
                        $difference = $studentTime->diffInMinutes($trialTime);
                        if ($difference <= 31 && $difference >= 29) {
                            $customer->notify(new RemindCustomerForUpcomingTrialClass($trial_class));
                        }
                    }
                }
            }
            $this->info('Completed Successfully!');
            return Command::SUCCESS;
        } catch (Exception $e) {
            Log::info("push_updates_for_upcoming_classes  Job Failed");
            Log::error($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Participant not joined issue detected',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
