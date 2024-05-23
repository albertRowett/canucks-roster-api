<?php

namespace App\Http\Services;

use App\Models\DraftTeam;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\Team;

class PlayerService
{
    public function getPositionIdByPositionName(string $name): ?int
    {
        $position = Position::firstOrCreate([
            'name' => $name,
        ]);

        if ($position) {
            return $position->id;
        }

        return null;
    }

    public function getNationalityIdByNationalityName(string $name): ?int
    {
        $nationality = Nationality::firstOrCreate([
            'name' => $name,
        ]);

        if ($nationality) {
            return $nationality->id;
        }

        return null;
    }

    public function getDraftTeamIdByDraftTeamName(string $name): ?int
    {
        $teamId = $this->getTeamIdByTeamName($name);

        if (is_null($teamId)) {
            return null;
        }
        
        $draftTeam = DraftTeam::firstOrCreate([
            'team_id' => $teamId,
        ]);

        if ($draftTeam) {
            return $draftTeam->id;
        }

        return null;
    }

    private function getTeamIdByTeamName(string $name): ?int
    {
        $team = Team::firstOrCreate([
            'name' => $name,
        ]);

        if ($team) {
            return $team->id;
        }

        return null;
    }
}
