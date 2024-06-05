<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AddTimezoneToUserTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddTimeToUserTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands add timezone to user table after fetching from availability table';

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
            $user = User::with(['availability'])->chunk(25, function ($eachuser) {
                foreach ($eachuser as $key => $value) {
                    if (!is_null($value->availability)) {
                        //these users have availability
                        if (is_null($value->timezone)) {
                            $value->update([
                                'timezone' => $value->availability->timezone,
                            ]);
                        }
                    } else {
                        // these users don't have an availability
                        continue;
                    }
                }
            });
        } catch (Exception $e) {
            $this->info($e);
            Log::info($e);
            SendJobErrorMailJob::dispatch([
                'function' => 'AddTimeToUserTable cron job',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
