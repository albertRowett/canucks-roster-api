<?php

namespace App\Http\Services;

use App\Models\PreviousTeam;

class PreviousTeamService
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function getPreviousTeamIdsByPreviousTeamNames(array $names): array
    {
        $teamIds = array_map(function (string $name): int {
            return $this->teamService->getTeamIdByTeamName($name);
        }, $names);

        $previousTeamIds = array_map(function (int $teamId): int {
            $previousTeam = PreviousTeam::firstOrCreate([
                'team_id' => $teamId,
            ]);

            return $previousTeam->id;
        }, $teamIds);

        return $previousTeamIds;
    }
}
