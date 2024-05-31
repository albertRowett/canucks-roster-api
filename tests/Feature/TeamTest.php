<?php

namespace Tests\Feature;

use App\Http\Services\TeamService;
use App\Models\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    protected TeamService $teamService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teamService = $this->app->make(TeamService::class);
    }

    public function test_get_team_id_by_existing_team_name_success(): void
    {
        $team = Team::factory()->create();
        $teamId = $this->teamService->getTeamIdByTeamName($team->name);
        $this->assertEquals($team->id, $teamId);
    }

    public function test_get_team_id_by_new_team_name_success(): void
    {
        $this->teamService->getTeamIdByTeamName('Vancouver Canucks');
        $this->assertDatabaseHas('teams', [
            'id' => 1,
            'name' => 'Vancouver Canucks',
        ]);
    }
}
