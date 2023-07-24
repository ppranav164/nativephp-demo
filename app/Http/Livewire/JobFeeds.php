<?php

namespace App\Http\Livewire;

use App\Traits\LaraJobsChecker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class JobFeeds extends Component
{
    public $windowFocused = true;

    use LaraJobsChecker;

    protected $listeners = [
        'native:'.\Native\Laravel\Events\Windows\WindowFocused::class => 'windowFocused',
        'native:'.\Native\Laravel\Events\Windows\WindowBlurred::class => 'windowBlurred',
    ];

    public $jobs = [];

    public $total_jobs = 0;

    public function render()
    {
        $jobs =  $this->getJobFeeds();

        $jobs = is_array($jobs) ? $jobs : [];

        // Convert the array to a Laravel collection and parse dates to Carbon instances
        $collection = collect($jobs)->map(function ($job) {
            $job['published_date'] = Carbon::parse($job['published_date']);
            return $job;
        });

        // Get the current date (today)
        $currentDate = Carbon::now();

        // Filter the collection to get jobs published today
        // $jobsPublishedToday = $collection->filter(function ($job) use ($currentDate) {
        //     return $job['published_date']->isToday($currentDate);
        // });

        // Sort the collection by the latest published_date
        $sortedJobs = $collection->sortByDesc('published_date');

        $this->jobs = collect($sortedJobs)->all();

        $this->total_jobs = $sortedJobs->count();

        return view('livewire.job-feeds');
    }

    public function windowFocused()
    {
        Log::info('windowFocused');
        $this->windowFocused = true;
    }
 
    public function windowBlurred()
    {
        Log::info('windowBlurred');
        $this->windowFocused = false;
    }

    public function update()
    {
        $this->showAlert('Larajobs', 'Jobs Refreshed!');
    }
}
