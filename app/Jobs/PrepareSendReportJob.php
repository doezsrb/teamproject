<?php

namespace App\Jobs;

use Throwable;
use App\Models\Team;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class PrepareSendReportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $teams = Team::all();
        $batchJobs = [];
        foreach ($teams as $team) {


            foreach ($team->users as $teamuser) {
                array_push($batchJobs, new SendReportJob($teamuser, $team));
            }
            $user = User::find($team->user->id);
            array_push($batchJobs, new SendReportJob($user, $team));
        }
        Bus::batch($batchJobs)->catch(function (Batch $batch, $e) {
            Log::error('error batching');
        })->finally(function (Batch $batch) {
            Log::error('batch finshed');
        })->dispatch();
    }
}
