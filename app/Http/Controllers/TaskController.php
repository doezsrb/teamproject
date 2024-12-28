<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, Request $request)
    {
        //
        Gate::authorize('create-task', $project);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'days' => ['required']
        ]);
        Task::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'status' => 'pending',
            'finish_date' => now()->addDays((int)$request->get('days')),
            'project_id' => $project->id,
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('project.show', $project->id)->with('success', 'Task is created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    private function updateWorkSession($request, $task)
    {
        $user = User::find($request->user()->id);
        if ($request->get('status') == 'pending') {
            if ($task->workSession) {
                $task->workSession->delete();
            }
        } else if ($request->get('status') == 'in_progress') {
            if (!$task->workSession) {
                $task->workSession()->create([
                    'user_id' => $user->id,
                    'start_date' => now(),
                ]);
            }
        } else {
            if ($task->workSession) {
                if ($task->workSession->end_time == null) {
                    $task->workSession->update([
                        'end_date' => now(),
                    ]);
                }
            }
        }
    }
    public function update(Request $request, Task $task)
    {
        //
        Gate::authorize('update-task', $task);

        $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);
        $this->updateWorkSession($request, $task);

        $task->update([
            'status' => $request->get('status')
        ]);

        return redirect()->route('project.show', $task->project->id)->with('success', 'Task status is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        Gate::authorize('delete-task', $task);

        $task->delete();

        return redirect()->route('project.show', $task->project->id)->with('success', 'Task is deleted successfully.');
    }
}
