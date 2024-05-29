<?php

namespace App\Http\Services;

use App\Models\DraftTeam;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\PreviousTeam;
use App\Models\Team;

class PlayerService
{
    public function getPositionIdByPositionName(string $name): int
    {
        $position = Position::firstOrCreate([
            'name' => $name,
        ]);

        return $position->id;
    }

    public function getNationalityIdByNationalityName(string $name): int
    {
        $nationality = Nationality::firstOrCreate([
            'name' => $name,
        ]);

        return $nationality->id;
    }

    public function getDraftTeamIdByDraftTeamName(string $name): int
    {
        $teamId = $this->getTeamIdByTeamName($name);

        $draftTeam = DraftTeam::firstOrCreate([
            'team_id' => $teamId,
        ]);

        return $draftTeam->id;
    }

    public function getPreviousTeamIdsByPreviousTeamNames(array $names): array
    {
        $teamIds = array_map(function (string $name): int {
            return $this->getTeamIdByTeamName($name);
        }, $names);

        $previousTeamIds = array_map(function (int $teamId): int {
            $previousTeam = PreviousTeam::firstOrCreate([
                'team_id' => $teamId,
            ]);

            return $previousTeam->id;
        }, $teamIds);

        return $previousTeamIds;
    }

    private function getTeamIdByTeamName(string $name): int
    {
        $team = Team::firstOrCreate([
            'name' => $name,
        ]);

        return $team->id;
    }
}
