<?php

namespace App\Jobs;

use App\Mail\Twominbeforemail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TwominbeforeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $users;
    protected $class;
    public function __construct($users, $class)
    {
        //
        $this->users = $users;
        $this->class = $class;
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
            foreach ($this->users as $user) {
                Mail::to($user->email)->send(new Twominbeforemail($user, $this->class));
            }
        } catch (Exception $e) {
            Log::info("3 min before que failed");
            Log::error($e->getMessage());
        }
    }
}
