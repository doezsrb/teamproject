<?php

use App\Http\Controllers\CommentController;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Mail\SendReport;
use App\Models\Comment;
use App\Services\TimeZoneService;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/testlang', function (Request $request) {


    return Inertia::render("TestLang", [
        'welcometext' => __('Welcome to laravel site.')
    ]);
});
Route::get('/test', function (Request $request, TimeZoneService $timeZoneService) {
    $user = User::all()->first();
    /* $teams = $user->createdTeams()->with('projects.tasks')->get(); */
    $team = $user->createdTeams[0];
    $projects = $team->projects()->withCount(['tasks as completed_tasks_count' => function ($query) {
        $query->where('status', 'completed');
    }])->withCount('tasks')->get();

    /* return response()->json([
        'data' => [
            'projects' => $projects,
            'team' => $team
        ]
    ]); */
    return new SendReport($team, $projects);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ProjectController::class)->group(function () {
        Route::put('/project/create/{team}', 'store')->name('project.store');
        Route::get('/project/create/{team}', 'create')->name('project.create');
        Route::get('/project/show/{project}', 'show')->name('project.show');
    });
    Route::controller(TaskController::class)->group(function () {
        Route::get('/task/show/{task}', 'show')->name('task.show');
        Route::put('/task/create/{project}', 'store')->name('task.store');
        Route::get('/task/create/{project}', 'create')->name('task.create');
        Route::post('/task/update/{task}', 'update')->name('task.update');
        Route::delete('/task/delete/{task}', 'destroy')->name('task.delete');
    });
    Route::controller(CommentController::class)->group(function () {
        Route::put('/comment/create/team/{team}', 'createTeamComment')->name('create.team.comment');
        Route::put('/comment/create/project/{project}', 'createProjectComment')->name('create.project.comment');
        Route::get('/comments/{team}', 'getTeamComments')->name('get.team.comments');
    });
    Route::controller(ReportController::class)->group(function () {
        Route::put('/report/{comment}', 'createReport')->name('report.comment');
    });
    Route::controller(TeamController::class)->group(function () {

        Route::get('/team/show/{team}', 'show')->name('team.show');
        Route::post('/team/{team}', 'addUser')->name('team.adduser');
        Route::put('/team/create', 'store')->name('team.create');
        Route::get('/team/create', 'create')->name('team.createform');
        Route::get('/team', 'index')->name('team.index');
        Route::post('/team/setrole/{team}', 'setRole')->name('team.setrole');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
