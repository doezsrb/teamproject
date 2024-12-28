<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = User::find($request->user()->id);
        $createdTeams = $user->createdTeams()->withCount('projects')->with(['projects' => function ($query) {
            $query->withCount('tasks');
        }])->get()->map(function ($team) {

            $team->tasks_count = $team->projects->sum(function ($project) {
                return $project->tasks->count();
            });
            return $team;
        });;
        $teams = $user->teams;

        if ($request->is('api/*')) {
            return response()->json([

                'teams' => $teams,
                'createdTeams' => $createdTeams,
                'roles' => $user->roles,
                'user' => $user
            ]);
        } else {
            return Inertia::render('Team/Index', [
                'teams' => $teams,
                'createdTeams' => $createdTeams,
                'roles' => $user->roles,
                'user' => $user
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Team/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function setRole(Team $team, Request $request)
    {
        Gate::authorize('add-role-to-user', $team);
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find($request->get('user_id'));
        $role = Role::find($request->get('role_id'));
        $user->roles()->attach($role->id, ['team_id' => $team->id]);


        return redirect()->route('team.show', $team->id)->with('success', 'User is assigned successfully.');
    }
    public function addUser(Team $team, Request $request)
    {
        //!todo dodaj user stavi gate:authorize...
        Gate::authorize('add-user', $team);
        $request->validate([
            'email' => 'required|email',

        ]);
        $user = User::where('email', $request->get('email'))->first();
        if ($user != null) {
            $team->users()->attach([$user->id]);
            if ($request->is('api/*')) {
                return response()->json(['msg' => 'success']);
            } else {
                return redirect()->route('team.show', $team->id)->with('success', 'User added successfully.');
            }
        } else {
            if ($request->is('api/*')) {
                return response()->json(['msg' => 'failed']);
            } else {
                return redirect()->back()->withErrors(['email' => 'User not found.']);
            }
        }
    }
    public function store(Request $request)
    {
        //



        $request->validate([
            'name' => 'required',
        ]);
        Team::create([
            'name' => $request->get('name'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->route('team.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team, Request $request)
    {
        //

        if ($request->is('api/team/*')) {
            return response()->json([
                'team' => $team,
                'comments' => $team->comments()->with('user')->take(5)->get(),
                'users' => $team->users,
                'owner' => $team->user,
                'projects' => $team->projects
            ]);
        } else {
            return Inertia::render('Team/Show', [
                'team' => $team,
                'comments' => $team->comments()->with('user')->take(5)->get(),
                'users' => $team->users,
                'owner' => $team->user,
                'projects' => $team->projects
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
