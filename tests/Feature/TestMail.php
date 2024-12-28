<?php

namespace Tests\Feature;

use App\Mail\SendReport;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestMail extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_mailable_content(): void
    {
        $user = User::all()->first();
        $mail = new SendReport($user);
        $mail->assertSeeInHtml($user->tasks[0]->name);
    }
}
