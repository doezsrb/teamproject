<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TimeZoneService
{
    protected $apiKey;
    public function __construct()
    {
        $this->apiKey = "P638A5FV0XQV";
    }
    public function getTimeZone($location)
    {
        $response = Http::get('http://api.timezonedb.com/v2.1/get-time-zone', [
            'key' => $this->apiKey,
            'format' => 'json',
            'by' => 'zone',
            'zone' => $location,
        ]);
        return $response->json();
    }
}
