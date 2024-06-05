<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Models\Notification;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notification:Clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is supposed to delete all the trial update  notifications after one day';

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
       try{

            DB::transaction(function () {
            
                    $notification = Notification::where([
                    'type'=>'trial_update',
                    ])->whereDate('json->trialClass->starts_at', '<', Carbon::today('UTC')->addDay())->delete();
            });

       }catch(Exception $e){    
        $this->info($e);
        // Log::info($e);
        SendJobErrorMailJob::dispatch([
            'function' => 'Clear Notification  Cron job error',
            'message' => $e->getMessage(),
        ]);
       }
    }
}
