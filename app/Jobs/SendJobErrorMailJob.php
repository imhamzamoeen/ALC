<?php

namespace App\Jobs;

use App\Mail\SendJobError;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendJobErrorMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $details;
    public function __construct($details = [])
    {
        //
        $this->details = $details;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $user = [       //developer emails
                'hamza.moeen@alquranclasses.com',
                'haris.khan@alquranclasses.com',
                'mahtab.ali@alquranclasses.com'
            ];
            foreach ($user as $users) {
                Mail::to($users)->send(new SendJobError($this->details));
            }
        } catch (Exception $e) {
            Log::info("send job error detected");
            Log::error($e->getMessage());
        }
    }
}
