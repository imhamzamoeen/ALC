<?php

namespace App\Jobs;

use App\Mail\ParticpantNotJoinedMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Classnotjoinedyetjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $class;
    public function __construct($users,$class)
    {
        //
        $this->user = $users;
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
            Log::info($this->user);
            Mail::to($this->user->email)->send(new ParticpantNotJoinedMail($this->class));
        } catch (Exception $e) {
            Log::info("participant not joined que failed");
            Log::error($e->getMessage());
        }
    }
}
