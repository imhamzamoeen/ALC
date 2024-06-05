<?php

namespace App\Jobs;

use App\Services\ZoomWebhookCalculationService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreUserJoinedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $details;
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

//     public function middleware()
// {
//     return [(new WithoutOverlapping($this->user->id))->releaseAfter(30)];
// }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            return (new ZoomWebhookCalculationService)->StoreUserAttendanceJoin($this->details);
        } catch (Exception $e) {
            Log::info(" Store user joined que failed ");
            Log::debug($e->getMessage());
        }
    }
}
