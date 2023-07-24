<?php

namespace App\Listeners;

use App\Events\NewLaraJobEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Native\Laravel\Facades\Notification;
use Illuminate\Support\Facades\Http;

class LaraJobListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewLaraJobEvent $event): void
    {
        Log::info('NewLaraJobEvent');

        Log::info('Jobs...');

        $response = Http::get('http://127.0.0.1:8100/pushjob');
        
    }
}
