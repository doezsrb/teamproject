<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => fake()->text(),
            'user_id' => 258
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Comment $comment) {
            $team = Team::first();
            $team->comments()->attach($comment->id);
        });
    }
}
