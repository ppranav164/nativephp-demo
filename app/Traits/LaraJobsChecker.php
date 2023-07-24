<?php

namespace App\Traits;

use App\Models\LaraJobs;
use Native\Laravel\Facades\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;


trait LaraJobsChecker {


    public function fetchJobs()
    {
        $rssUrl = 'https://larajobs.com/feed-test';
        
        $response = Http::get($rssUrl);

        $jobs = [];

        if ($response->successful()) {
            $rssData = $response->body();
            $xml = new SimpleXMLElement($rssData);

            foreach ($xml->channel->item as $item) {
                
                $job = [
                    'title'           => (string) $item->title,
                    'link'            => (string) $item->link,
                    'published_date'  => (string) $item->pubDate,
                    'creator'         => (string) $item->children('dc', true)->creator,
                    'category'        => (string) $item->category,
                    'guid'            => (string) $item->guid,
                ];

                $jobs[] = $job;
            }

            $this->loadJobFeedsForAlerts($jobs);

            $this->loadJobFeeds($jobs);
        }

        return $jobs;
    }


    public function showAlert(string $title, $desc = 'You got a new job post alert, check it out before they are gone')
    {
        Notification::title($title)
            ->message($desc)
            ->show();
    }


    public function getJobFeeds()
    {
        $jobs = $this->getDataFileContents();
        
        return json_decode($jobs, true);
    }


    public function getLatestJobs()
    {
        return json_decode($this->getJobFeedsForAlerts(), true);
    }


    public function loadJobFeeds($json_data)
    {
        $existingData = json_decode( $this->dataStorageFile(), true);

        $existingData = array_merge(is_array($existingData) ? $existingData : [], $json_data);

        $updatedJsonData = json_encode($existingData);

        file_put_contents('larajoblists.json', $updatedJsonData);
    }

    public function loadJobFeedsForAlerts($json_data)
    {
        $updatedJsonData = json_encode($json_data);
        file_put_contents('notifications.json', $updatedJsonData);
    }

    public function getJobFeedsForAlerts()
    {
        return file_get_contents('../notifications.json');
    }

    public function dataStorageFile()
    {
        return file_get_contents($this->fileName());
    }


    public function getDataFileContents()
    {
        return file_get_contents('../'. $this->fileName());
    }


    public function fileName()
    {
        return 'larajoblists.json';
    }

}