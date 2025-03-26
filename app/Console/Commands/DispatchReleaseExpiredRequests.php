<?php

namespace App\Console\Commands;

use App\Jobs\ReleaseExpiredRequestsJob;
use Illuminate\Console\Command;

class DispatchReleaseExpiredRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-release-expired-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a job to release expired reservations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ReleaseExpiredRequestsJob::dispatch();
        $this->info('Shift reservation release job dispatched.');
    }
}
