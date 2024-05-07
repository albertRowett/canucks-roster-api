<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PreviousTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_players_success(): void
    {
        Player::factory()->count(0)->has(PreviousTeam::factory()->count(1))->create();

        $response = $this->getJson('/api/players');
        $response->dd();
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
                        'previous_teams.0.team.name' => 'string'
                    ]);
                })
                    ->where('message', 'Players successfully retrieved');
            });
    }
}
