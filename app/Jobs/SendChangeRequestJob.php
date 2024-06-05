<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendChangeRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public  $details;
    public function __construct($details)
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

            Mail::send('emails.partials.support.ChangeRequest.mail', ["details" => $this->details] , function ($message) {
                $message->to(config('emails.SALES_SUPPORT_EMAIL'))->subject('AlQuran Change Request For ' . beautify_slug($this->details['change_type']));
            });
        } catch (Exception $e) {
            Log::info("send Change Reequest to sale support failed ");
            Log::error($e->getMessage());
        }
    }
}
