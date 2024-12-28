<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Gate::define('delete-task', function (User $user, Task $task) {
            if ($user->id == $task->project->team->user_id) {
                return true;
            }
            if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $task->project->team->id)->exists()) {
                return true;
            }
            return false;
        });
        Gate::define('update-task', function (User $user, Task $task) {
            if ($task->project->team->user_id == $user->id) {
                return true;
            } else if ($task->project->team->users->contains('id', $user->id)) {
                return true;
            }
            return false;
        });
        Gate::define('create-task', function (User $user, Project $project) {
            $team = $project->team;
            if ($user->id == $team->user_id) {
                return true;
            }
            if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            } else if ($user->roles()->where('name', 'Manager')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            }
            return false;
        });
        Gate::define('add-role-to-user', function (User $user, Team $team) {
            if ($user->id == $team->user_id) {
                return true;
            } else if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            } else if ($user->roles()->where('name', 'Manager')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            }
            return false;
        });
        Gate::define('add-user', function (User $user, Team $team) {
            if ($user->id == $team->user_id) {
                return true;
            } else if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            } else if ($user->roles()->where('name', 'Manager')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            }
            return false;
        });

        Gate::define('create-project', function (User $user, Team $team) {
            if ($user->id == $team->user_id) {
                return true;
            } else if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $team->id)->exists()) {
                return true;
            }
            return false;
        });
    }
}
