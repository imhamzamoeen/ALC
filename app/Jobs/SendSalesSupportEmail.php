<?php

namespace App\Jobs;

use App\Mail\SalesSupportMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSalesSupportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $salesteam;
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
        //
        $this->salesteam = [
            'waqas.ashraf@alquranclasses.com',
            'sumaira.yousaf@alquranclasses.com'
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            foreach ($this->salesteam as $team) { // loop 
              
                    Mail::to($team)->send(new SalesSupportMail($this->details));
                
            }
        } catch (Exception $e) {
        }
    }
}
