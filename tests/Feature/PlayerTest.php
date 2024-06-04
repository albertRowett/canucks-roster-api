<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PreviousTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_players_success(): void
    {
        Player::factory()->count(2)->has(PreviousTeam::factory()->count(1))->create();

        $response = $this->getJson('/api/players');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 2, function (AssertableJson $json) {
                    $json->whereAllType([
                        'id' => 'integer',
                        'name' => 'string',
                        'jersey_number' => 'integer',
                        'date_of_birth' => 'string',
                        'position.name' => 'string',
                        'nationality.name' => 'string',
                    ]);
                })
                    ->where('message', 'Players successfully retrieved');
            });
    }

    public function test_get_player_by_jersey_number_success(): void
    {
        $player = Player::factory()->has(PreviousTeam::factory())->create();

        $response = $this->getJson("/api/players/$player->jersey_number");
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 1, function (AssertableJson $json) {
                    $json->whereAllType([
                        'id' => 'integer',
                        'name' => 'string',
                        'jersey_number' => 'integer',
                        'date_of_birth' => 'string',
                        'position.name' => 'string',
                        'nationality.name' => 'string',
                        'draft_team.team.name' => 'string',
                        'previous_teams.0.team.name' => 'string',
                    ]);
                })
                    ->where('message', 'Player successfully retrieved');
            });
    }

    public function test_player_not_found(): void
    {
        $response = $this->getJson('/api/players/1');
        $response->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player with jersey number 1 not found');
            });
    }

    public function test_add_player_success(): void
    {
        $response = $this->postJson('/api/players', [
            'name' => 'J. T. Miller',
            'jerseyNumber' => 9,
            'dateOfBirth' => '1993-03-14',
            'position' => 'Center',
            'nationality' => 'USA',
            'draftTeam' => 'New York Rangers',
            'previousTeams' => ['New York Rangers', 'Tampa Bay Lightning'],
        ]);
        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player added');
            });
        $this->assertDatabaseHas('players', [
            'name' => 'J. T. Miller',
            'jersey_number' => 9,
            'date_of_birth' => '1993-03-14',
            'position_id' => 1,
            'nationality_id' => 1,
            'draft_team_id' => 1,
        ]);
        $this->assertDatabaseHas('player_previous_team', [
            'player_id' => 1,
            'previous_team_id' => 1,
        ]);
        $this->assertDatabaseHas('player_previous_team', [
            'player_id' => 1,
            'previous_team_id' => 2,
        ]);
    }
}
