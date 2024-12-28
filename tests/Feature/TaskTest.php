<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    private $taskname = 'Test Task';
    public function test_admin_and_moderator_can_create_task_in_project(): void
    {
        $team = Team::all()->first();
        $user = $team->user;
        $this->actingAs($user);

        $project = $team->projects()->first();

        $response = $this->put(route('task.store', ['project' => $project->id]), [

            'name' => $this->taskname,
            'description' => 'Test Task Description',
            'days' => 10,
        ]);
        $response->assertRedirect(route('project.show', ['project' => $project->id]));
    }
    public function test_users_from_team_can_update_status(): void
    {
        $task = Task::where('name', $this->taskname)->first();
        $team = $task->project->team;
        $user = $team->user;
        $this->actingAs($user);
        $response = $this->post(route('task.update', ['task' => $task->id]), [
            'status' => 'completed',
        ]);

        $this->assertEquals($task->refresh()->status, 'completed');
    }
    public function test_admin_can_delete_task(): void
    {
        $task = Task::where('name', $this->taskname)->first();
        $admin = User::factory()->create();
        $role = Role::where('name', 'Admin')->first();
        $admin->roles()->attach($role->id, ['team_id' => $task->project->team->id]);

        $this->actingAs($admin);
        $response = $this->delete(route('task.delete', ['task' => $task->id]));
        $response->assertRedirect(route('project.show', ['project' => $task->project->id]));
    }
}
