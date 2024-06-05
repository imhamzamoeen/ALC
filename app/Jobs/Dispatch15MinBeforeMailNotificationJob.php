<?php

namespace App\Jobs;

use App\Notifications\Send15minBeforeNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Dispatch15MinBeforeMailNotificationJob implements ShouldQueue
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
            Notification::send(
                [$this->users[0], $this->users[1]],
                new Send15minBeforeNotification($this->class)
            );
        } catch (Exception $e) {
            Log::info("15 min before que failed");
            Log::error($e->getMessage());
        }
    }
}
