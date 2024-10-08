<?php

namespace Tests\Feature;

use App\Models\Nationality;
use App\Models\Player;
use App\Models\Position;
use App\Models\PreviousTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_players_success(): void
    {
        Player::factory()->count(2)->has(PreviousTeam::factory())->create();

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
                        'draft_team.team.name' => 'string',
                        'previous_teams.0.team.name' => 'string',
                    ]);
                })
                    ->where('message', 'Players successfully retrieved');
            });
    }

    public function test_get_removed_players_success(): void
    {
        Player::factory()->create();
        Player::factory()->trashed()->create();

        $response = $this->getJson('/api/players?removed=1');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 1)
                    ->where('message', 'Players successfully retrieved');
            });
    }

    public function test_get_removed_players_invalid(): void
    {
        $response = $this->getJson('/api/players?removed=non-boolean');  // Validation requires boolean
        $response->assertStatus(422)
            ->assertInvalid('removed');
    }

    public function test_get_position_filtered_players_success(): void
    {
        Position::factory(['name' => 'Center'])->create();
        Player::factory()->create();
        Player::factory(['position_id' => 1])->create();

        $response = $this->getJson('/api/players?position=Center');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 1)
                    ->where('message', 'Players successfully retrieved');
            });
    }

    public function test_get_filtered_players_invalid_position(): void
    {
        $response = $this->getJson('/api/players?position=Forward');  // Validation requires one of 'Goaltender'/'Defense'/'Center'/'Left wing'/'Right wing'
        $response->assertStatus(422)
            ->assertInvalid('position');
    }

    public function test_get_nationality_filtered_players_success(): void
    {
        Nationality::factory(['name' => 'USA'])->create();
        Player::factory()->create();
        Player::factory(['nationality_id' => 1])->create();

        $response = $this->getJson('/api/players?nationality=USA');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 1)
                    ->where('message', 'Players successfully retrieved');
            });
    }

    public function test_get_filtered_players_invalid_nationality(): void
    {
        $response = $this->getJson('/api/players?nationality=USA');  // Validation requires name from nationalities table in database
        $response->assertStatus(422)
            ->assertInvalid('nationality');
    }

    public function test_get_player_by_jersey_number_success(): void
    {
        if (rand(0, 1)) {
            $player = Player::factory()->trashed()->has(PreviousTeam::factory())->create();
        } else {
            $player = Player::factory()->has(PreviousTeam::factory())->create();
        }

        $response = $this->getJson("/api/players/$player->jersey_number");
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $json) {
                    $json->whereAllType([
                        'id' => 'integer',
                        'name' => 'string',
                        'jersey_number' => 'integer',
                        'date_of_birth' => 'string',
                        'deleted_at' => 'string|null',
                        'position.name' => 'string',
                        'nationality.name' => 'string',
                        'draft_team.team.name' => 'string',
                        'previous_teams.0.team.name' => 'string',
                    ]);
                })
                    ->where('message', 'Player successfully retrieved');
            });
    }

    public function test_get_player_not_found(): void
    {
        $response = $this->getJson('/api/players/1');
        $this->assertPlayerNotFound($response);
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

    public function test_add_player_no_data(): void
    {
        $response = $this->postJson('/api/players', []);
        $response->assertStatus(422)
            ->assertInvalid(['name', 'jerseyNumber', 'dateOfBirth', 'position', 'nationality']);
    }

    public function test_add_player_invalid_data(): void
    {
        $response = $this->postJson('/api/players', [
            'name' => ['J. T. Miller'],             // Validation requires string
            'jerseyNumber' => 9.1,                  // Validation requires integer
            'dateOfBirth' => '14-03-1993',          // Validation requires Y-m-d format
            'position' => 'Forward',                // Validation requires one of 'Goaltender'/'Defense'/'Center'/'Left wing'/'Right wing'
            'nationality' => ['USA'],               // Validation requires string
            'draftTeam' => 1,                       // Validation requires string
            'previousTeams' => 'New York Rangers',  // Validation requires array
        ]);
        $response->assertStatus(422)
            ->assertInvalid(['name', 'jerseyNumber', 'dateOfBirth', 'position', 'nationality', 'draftTeam', 'previousTeams']);
    }

    public function test_update_player_success(): void
    {
        $player = Player::factory()->has(PreviousTeam::factory())->create();

        $response = $this->putJson("/api/players/$player->jersey_number", [
            'name' => 'J. T. Miller',
            'jerseyNumber' => 9,
            'dateOfBirth' => '1993-03-14',
            'position' => 'Center',
            'nationality' => 'USA',
            'draftTeam' => 'New York Rangers',
            'previousTeams' => ['New York Rangers', 'Tampa Bay Lightning'],
        ]);
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player updated');
            });
        $this->assertDatabaseCount('players', 1);
        $this->assertDatabaseHas('players', [
            'name' => 'J. T. Miller',
            'jersey_number' => 9,
            'date_of_birth' => '1993-03-14',
            'position_id' => 2,
            'nationality_id' => 2,
            'draft_team_id' => 2,
        ]);
        $this->assertDatabaseMissing('player_previous_team', [
            'player_id' => 1,
            'previous_team_id' => 1,
        ]);
        $this->assertDatabaseHas('player_previous_team', [
            'player_id' => 1,
            'previous_team_id' => 2,
        ]);
        $this->assertDatabaseHas('player_previous_team', [
            'player_id' => 1,
            'previous_team_id' => 3,
        ]);
    }

    public function test_update_player_not_found(): void
    {
        $response = $this->putJson('/api/players/1');
        $this->assertPlayerNotFound($response);
    }

    public function test_update_player_no_data(): void
    {
        $player = Player::factory()->create();

        $response = $this->putJson("/api/players/$player->jersey_number", []);
        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'A minimum of 1 data field is required');
            });
    }

    public function test_update_player_invalid_data(): void
    {
        $player = Player::factory()->create();

        $response = $this->putJson("/api/players/$player->jersey_number", [
            'name' => ['J. T. Miller'],             // Validation requires string
            'jerseyNumber' => 9.1,                  // Validation requires integer
            'dateOfBirth' => '14-03-1993',          // Validation requires Y-m-d format
            'position' => 'Forward',                // Validation requires one of 'Goaltender'/'Defense'/'Center'/'Left wing'/'Right wing'
            'nationality' => ['USA'],               // Validation requires string
            'draftTeam' => 1,                       // Validation requires string
            'previousTeams' => 'New York Rangers',  // Validation requires array
        ]);
        $response->assertStatus(422)
            ->assertInvalid(['name', 'jerseyNumber', 'dateOfBirth', 'position', 'nationality', 'draftTeam', 'previousTeams']);
    }

    public function test_remove_player_success(): void
    {
        $player = Player::factory()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number", ['action' => 'remove']);
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player removed from roster');
            });
        $this->assertSoftDeleted($player);
    }

    public function test_remove_player_already_removed(): void
    {
        $player = Player::factory()->trashed()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number", ['action' => 'remove']);
        $response->assertStatus(400)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player already removed from roster');
            });
        $this->assertSoftDeleted($player);
    }

    public function test_restore_player_success(): void
    {
        $player = Player::factory()->trashed()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number", ['action' => 'restore']);
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player restored to roster');
            });
        $this->assertNotSoftDeleted($player);
    }

    public function test_restore_player_already_on_roster(): void
    {
        $player = Player::factory()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number", ['action' => 'restore']);
        $response->assertStatus(400)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player already on roster');
            });
        $this->assertNotSoftDeleted($player);
    }

    public function test_update_player_status_player_not_found(): void
    {
        $response = $this->patchJson('api/players/1');
        $this->assertPlayerNotFound($response);
    }

    public function test_update_player_status_no_action(): void
    {
        $player = Player::factory()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number");
        $response->assertStatus(422)
            ->assertInvalid('action');
    }

    public function test_update_player_status_invalid_action(): void
    {
        $player = Player::factory()->create();

        $response = $this->patchJson("/api/players/$player->jersey_number", ['action' => 'another action']);
        $response->assertStatus(422)
            ->assertInvalid('action');
    }

    public function test_delete_player_success(): void
    {
        $player = Player::factory()->create();

        $response = $this->deleteJson("/api/players/$player->jersey_number");
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player deleted');
            });
        $this->assertModelMissing($player);
    }

    public function test_delete_player_not_found(): void
    {
        $response = $this->deleteJson('/api/players/1');
        $this->assertPlayerNotFound($response);
    }

    private function assertPlayerNotFound(TestResponse $response): void
    {
        $response->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Player with jersey number 1 not found');
            });
    }
}
