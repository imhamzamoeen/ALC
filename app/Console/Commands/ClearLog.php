<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Artisan;
use App\Jobs\SendJobErrorMailJob;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log_clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for clear LOG file';

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
            Log::info("Clear Log file");
            Artisan::call('log:clear');
        }catch (\Exception $e) {
            // DB::rollback();
            $this->info($e);
            Log::info($e);
            SendJobErrorMailJob::dispatch([
                'function' => 'clear log file error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
