<?php

namespace App\Console\Commands;

use App\Jobs\SendJobErrorMailJob;
use App\Traits\SDKTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ZoomCloudRecordingCommand extends Command
{
    use SDKTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoom:recording';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will get one day recordings from zoom and will save on the specified location ';

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
            $recordings = $this->GetRecordings(Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->startOfDay()->format('Y-m-d'))->toArray();
            // this will give us the recordings of one day and we will put that on s3 bucket 
            foreach ($recordings as $key => $value) {
                $download_url = $value['recording_files']['download_url'];
            }
        } catch (Exception    $e) {
            Log::info('zoom cloud recording command');
            Log::debug($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Zoom Cloud recording Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
