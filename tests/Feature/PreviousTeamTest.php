<?php

namespace Tests\Feature;

use App\Http\Services\PreviousTeamService;
use App\Models\PreviousTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PreviousTeamTest extends TestCase
{
    use DatabaseMigrations;

    protected PreviousTeamService $previousTeamService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->previousTeamService = $this->app->make(PreviousTeamService::class);
    }

    public function test_get_previous_team_ids_by_existing_previous_team_names(): void
    {
        $previousTeams = PreviousTeam::factory()->count(2)->create();
        $previousTeamsIds = $previousTeams->map(function (PreviousTeam $previousTeam): int {
            return $previousTeam->id;
        })->toArray();
        $teamNames = $previousTeams->map(function (PreviousTeam $previousTeam): string {
            return $previousTeam->team->name;
        })->toArray();
        $previousTeamIds = $this->previousTeamService->getPreviousTeamIdsByPreviousTeamNames($teamNames);
        $this->assertEquals($previousTeamsIds, $previousTeamIds);
    }

    public function test_get_previous_team_ids_by_new_team_names(): void
    {
        $this->previousTeamService->getPreviousTeamIdsByPreviousTeamNames(['Vancouver Canucks', 'New York Rangers']);
        $this->assertDatabaseHas('previous_teams', [
            'id' => 1,
            'team_id' => 1,
        ]);
        $this->assertDatabaseHas('previous_teams', [
            'id' => 2,
            'team_id' => 2,
        ]);
    }
}
