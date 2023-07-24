<?php

namespace App\Console\Commands;

use App\Events\NewLaraJobEvent;
use App\Traits\LaraJobsChecker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Native\Laravel\Facades\Notification;
use Illuminate\Support\Facades\Http;

class LaraJobsCommand extends Command
{
    use LaraJobsChecker;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:larajobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchJobs();

        (new NewLaraJobEvent([]));

        $response = Http::get('http://127.0.0.1:8100/pushjob');
    }
}
