<?php

namespace Tests\Feature;

use App\Http\Services\DraftTeamService;
use App\Models\DraftTeam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DraftTeamTest extends TestCase
{
    use DatabaseMigrations;

    protected DraftTeamService $draftTeamService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->draftTeamService = $this->app->make(DraftTeamService::class);
    }

    public function test_get_draft_team_id_by_existing_draft_team_name_success(): void
    {
        $draftTeam = DraftTeam::factory()->create();
        $team = $draftTeam->team;
        $draftTeamId = $this->draftTeamService->getDraftTeamIdByDraftTeamName($team->name);
        $this->assertEquals($draftTeam->id, $draftTeamId);
    }

    public function test_get_draft_team_id_by_new_draft_team_name_success(): void
    {
        $this->draftTeamService->getDraftTeamIdByDraftTeamName('Vancouver Canucks');
        $this->assertDatabaseHas('draft_teams', [
            'id' => 1,
            'team_id' => 1,
        ]);
    }
}
