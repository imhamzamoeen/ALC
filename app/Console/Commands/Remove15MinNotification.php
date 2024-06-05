<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Models\Notification;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Remove15MinNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Remove15Min:Command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will delete all the 15 min before notifications ';

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
                Notification::whereType('class_update')->whereDate('created_at','<=', Carbon::yesterday('UTC')->format('Y-m-d'))->delete();
            });
        } catch (Exception $e) {

            Log::info("Remove15MinNotification Job Failed");
            Log::error($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Remove15Min:Command issue detected',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
