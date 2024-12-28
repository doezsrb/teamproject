<?php

namespace App\Jobs;

use App\Models\Team;
use App\Models\User;
use App\Mail\SendReport;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendReportJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $user, public $team)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if ($this->batch()->cancelled()) {
            return;
        }
        $projects = $this->team->projects()->withCount(['tasks as completed_tasks_count' => function ($query) {
            $query->where('status', 'completed');
        }])->withCount('tasks')->get();

        Mail::to($this->user)->send(new SendReport($this->team, $projects));
    }
}
