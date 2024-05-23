<?php

namespace App\Http\Services;

use App\Models\Nationality;
use App\Models\Position;

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
}
