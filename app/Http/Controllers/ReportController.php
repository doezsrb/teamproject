<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //

    public function createReport(Comment $comment, Request $request)
    {

        $request->validate([
            'message' => 'required'
        ]);

        $report = Report::create([
            'message' => $request->get('message'),
            'user_id' => $request->user()->id,
            'comment_id' => $comment->id
        ]);
        $team = $comment->teams()->first();

        return redirect()->route('team.show', ['team' => $team->id])->with('status', $request->user()->email . ' reported successfully!');
    }
}
