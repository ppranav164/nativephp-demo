<?php

namespace App\Http\Controllers;

use App\Models\LaraJobs;
use App\Traits\LaraJobsChecker;
use Illuminate\Support\Facades\Log;
use Native\Laravel\Facades\Notification;

class TrackUpdatesController extends Controller
{
    use LaraJobsChecker;
    
    public function index()
    {
        $jobs =  $this->getJobFeeds();

        $jobs = is_array($jobs) ? $jobs : [];

        return view('welcome', compact('jobs'));
    }

    public function jobUpdate()
    {
        $jobs =  $this->getLatestJobs();

        $jobs = is_array($jobs) ? $jobs : [];

        foreach($jobs as $feed)
        {
            $this->showAlert($feed['title']);
        }

        return "OK";
    }

}
