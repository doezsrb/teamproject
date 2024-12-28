<?php

use App\Jobs\PrepareSendReportJob;
use App\Jobs\SendReportJob;
use App\Mail\SendReport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/* Schedule::job(new SendReportJob())->everyTwoMinutes(); */
Schedule::job(new PrepareSendReportJob())->everyTwoMinutes();
