<?php

namespace Database\Factories;

use App\Models\DraftTeam;
use App\Models\Nationality;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'jersey_number' => fake()->unique()->numberBetween(1, 99),
            'position_id' => Position::factory(),
            'date_of_birth' => fake()->date(),
            'nationality_id' => Nationality::factory(),
            'draft_team_id' => DraftTeam::factory()
        ];
    }
}
