<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    //

    public function createTeamComment(Team $team, Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user()->id,
        ]);
        $team->comments()->attach($comment->id);

        return redirect()->route('team.show', ['team' => $team->id]);
    }
    public function createProjectComment(Project $project, Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user()->id,
        ]);
        $project->comments()->attach($comment->id);

        return redirect()->route('project.show', ['project' => $project->id]);
    }
    public function getTeamComments(Team $team)
    {
        $comments = $team->comments()->with('user')->paginate(5);

        return Inertia::render('Comments/Show', [
            'comments' => $comments
        ]);
    }
}
