<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => fake()->name(),
        ];
    }

    public function setuser($userid): static
    {
        return $this->state(function (array $attributes) use ($userid) {
            return [
                'user_id' => $userid,
            ];
        });
    }
}
