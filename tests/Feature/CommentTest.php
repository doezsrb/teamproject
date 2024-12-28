<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /* public function test_create_team_comment(): void
    {
        $team = Team::all()->first();
        $user = User::find($team->user->id);
        $this->actingAs($user);

        $response = $this->put(route('create.team.comment', ['team' => $team->id]), [
            'comment' => 'Test team comment'
        ]);

        $response->assertRedirect(route('team.show', ['team' => $team->id]));
    }



    public function test_create_project_comment(): void
    {
        $team = Team::all()->first();
        $user = User::find($team->user->id);
        $project = $team->projects()->first();

        $this->actingAs($user);

        $response = $this->put(route('create.project.comment', ['project' => $project->id]), [
            'comment' => 'Test project comment'
        ]);
        $response->assertRedirect(route('project.show', ['project' => $project->id]));
    } */

    public function test_user_can_report_user_by_comment(): void
    {
        $user = User::find(258);
        $team = Team::first();
        $comment = $team->comments()->first();

        $this->actingAs($user);
        $response = $this->put(route('report.comment', ['comment' => $comment->id]), [
            'message' => "lorem ipsum dolor sit amet, consectetur adipiscing elit"
        ]);

        $response->assertRedirect(route('team.show', ['team' => $team->id]));
    }
}
