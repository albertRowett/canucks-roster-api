<?php

namespace App\Http\Services;

use App\Models\DraftTeam;

class DraftTeamService
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function getDraftTeamIdByDraftTeamName(string $name): int
    {
        $teamId = $this->teamService->getTeamIdByTeamName($name);

        $draftTeam = DraftTeam::firstOrCreate([
            'team_id' => $teamId,
        ]);

        return $draftTeam->id;
    }
}
