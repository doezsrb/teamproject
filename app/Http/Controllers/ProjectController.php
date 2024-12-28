<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProjectController extends Controller
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
    public function create(Team $team)
    {
        //
        return Inertia::render('Project/Create', [
            'team_id' => $team->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Team $team, Request $request)
    {
        //

        $request->validate([
            'name' => 'required',
            'description' => 'required',

            'days' => 'required',
        ]);
        Gate::authorize('create-project', $team);
        Project::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'team_id' => $team->id,
            'finish_date' => now()->addDays((int)$request->get('days')),
            'user_id' => $request->user()->id,
            'status' => 'progress'
        ]);
        if ($request->is('api/*')) {
            return response()->json([
                'msg' => 'success'
            ]);
        } else {
            return redirect()->route('team.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
        return Inertia::render('Project/Show', [
            'project' => $project,
            'comments' => $project->comments()->with('user')->get(),
            'tasks' => [
                'pending' => $project->tasks()->where('status', 'pending')->select('name', 'id')->get(),
                'progress' => $project->tasks()->where('status', 'in_progress')->select('name', 'id')->get(),
                'completed' => $project->tasks()->where('status', 'completed')->select('name', 'id')->get()
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
