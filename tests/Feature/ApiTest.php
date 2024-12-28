<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_teamsApi()
    {
        $user = User::where('email', 'ironlakdoes@gmail.com')->first();
        $tokenResponse = $this->postJson('/api/login', ['email' => $user->email, 'password' => "21031997"]);

        $token = $tokenResponse->json()['token'];
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/teams');
        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has('teams')->etc());
    }
    public function test_teamsShowApi()
    {
        $user = User::where('email', 'ironlakdoes@gmail.com')->first();
        $team = $user->createdTeams()->first();

        $tokenResponse = $this->postJson('/api/login', ['email' => $user->email, 'password' => '21031997']);
        $token = $tokenResponse->json()['token'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/team/' . $team->id);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->hasAll(['team', 'users', 'projects', 'owner']));
    }
}
