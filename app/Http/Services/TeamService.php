<?php

namespace App\Http\Services;

use App\Models\Team;

class TeamService
{
    public function getTeamIdByTeamName(string $name): int
    {
        $team = Team::firstOrCreate([
            'name' => $name,
        ]);

        return $team->id;
    }
}
