<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class ProjectTest extends TestCase
{

    /**
     * A basic feature test example.
     */

    private $firstTeamName = 'first team';
    public function test_user_can_create_team(): void
    {
        $user = User::all()->first();
        if ($user == null) {
            $user = User::factory()->create();
            /* $role = Role::where('name', 'Admin')->first();
            $user->roles()->attach([$role->id]); */
        }
        $this->actingAs($user);
        $response = $this->put(route('team.create'), [
            'name' => $this->firstTeamName,

        ]);
        /* $team = Team::where('name', 'teamname')->first(); */
        $response->assertRedirect(route('team.index'));
    }
    public function test_team_admin_can_add_user(): void
    {
        $team = Team::all()->first();
        $user = User::factory()->create();
        $role = Role::where('name', 'Admin')->first();
        $user->roles()->attach($role->id, ['team_id' => $team->id]);
        $this->actingAs($user);

        $newUser = User::factory()->create();
        $response = $this->post(route('team.adduser', [
            'team' => $team->id
        ]), [
            'email' => $newUser->email
        ]);
        $response->assertRedirect(route('team.show', ['team' => $team->id]));
    }


    public function test_admin_can_create_project(): void
    {
        $team = Team::where('name', $this->firstTeamName)->first();
        $user = User::whereHas('roles', function ($query) use ($team) {
            $query->where('name', 'Admin')->where('role_user.team_id', $team->id);
        })->first();
        $this->actingAs($user);
        $response = $this->put(route('project.store', ['team' => $team->id]), [
            'name' => 'testname',
            'days' => 3,
            'description' => 'testdescription',

        ]);
        //route('team.index', ['id' => $team->id])
        $response->assertRedirect(route('team.index'));
    }
    public function test_admin_can_set_manager(): void
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->with('roles')->first();
        $this->actingAs($user);
        Log::write('test', $user);
        $team = Team::find($user->roles[0]->pivot->team_id);
        $newUser = User::factory()->create();
        $role = Role::where('name', 'Manager')->first();
        $response = $this->post(route('team.setrole', ['team' => $team->id]), [
            'user_id' => $newUser->id,
            'role_id' => $role->id
        ]);
        $response->assertRedirect(route('team.show', ['team' => $team->id]));
    }
    public function test_manager_cant_create_project(): void
    {
        $team = Team::where('name', $this->firstTeamName)->first();
        $user = User::factory()->create();
        $role = Role::where('name', 'Manager')->first();
        $user->roles()->attach($role->id, ['team_id' => $team->id]);
        $this->actingAs($user);
        $response = $this->put(route('project.store', ['team' => $team->id]), [
            'name' => 'projectmanagercreated',
            "days" => 3,
            'description' => 'testdescription',

        ]);
        //route('team.index', ['id' => $team->id])
        $response->assertStatus(403);
    }

    public function test_admin_of_another_team_cant_add_user(): void
    {
        //todo: implement
        $oldTeam = Team::where('name', $this->firstTeamName)->first();

        $user = User::factory()->create();
        $team = Team::factory()->setuser($user->id)->create();
        $role = Role::where('name', 'Admin')->first();
        $user->roles()->attach($role->id, ['team_id' => $team->id]);
        $this->actingAs($user);
        $newUser = User::factory()->create();
        $response = $this->post(route('team.adduser', [
            'team' => $oldTeam->id
        ]), [
            'email' => $newUser->email
        ]);

        //route('team.index', ['id' => $team->id])
        $response->assertStatus(403);
    }
    public function test_admin_of_another_team_cant_create_project(): void
    {
        //todo: implement
        $oldTeam = Team::where('name', $this->firstTeamName)->first();

        $user = User::factory()->create();
        $team = Team::factory()->setuser($user->id)->create();
        $role = Role::where('name', 'Admin')->first();
        $user->roles()->attach($role->id, ['team_id' => $team->id]);
        $this->actingAs($user);

        $response = $this->put(route('project.store', ['team' => $team->id]), [
            'name' => 'testname',
            'days' => 3,
            'description' => 'testdescription',

        ]);
        //route('team.index', ['id' => $team->id])
        $response->assertStatus(403);
    }
}
