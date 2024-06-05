<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Models\Notification;
use App\Services\NotificationFilterService;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class DueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:NotificationFilter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to filter reschedule notifications like if the due date of the rescheduled notification is passed then it will be marked as cancelled';

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
            DB::transaction(function () {
                Log::info("Daily class schedule mail check");
                $notification = Notification::where([
                    'json->type' => 'Rescheduled',
                    'json->RescheduleRequest->status' => 'pending',
                ])->whereDate('json->RescheduleRequest->reschedule_date', '<=', Carbon::today('UTC'))->get(); // woh sari requests jo pending mian hn aur unki requested date aj s peechy reh gai  
                $updated_notification = $notification->each(function ($value, $key) {

                    $result_decoded = json_decode($value->json, true);
                    $object = new stdClass;
                    $object->reschedule_class_id = $result_decoded['RescheduleRequest']['id'];
                    $object->weekly_class_id = $result_decoded['WeeklyClass']['id'];
                    $object->notification_id = $value->id;
                    $result_decoded['RescheduleRequest']['updated_by'] == 'teacher' ?  $object->student_id = $result_decoded['RescheduleRequest']['student_id'] :  $object->teacher_id = $result_decoded['RescheduleRequest']['teacher_id'];


                    $response = NotificationFilterService::FilterNotification($object);
                    if ($response->status() == 409) {
                        Log::info($response);
                    }
                });
            });
        } catch (Exception $e) {   //
            Log::debug("Due notification command failed");
            Log::debug($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Notification due work Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
