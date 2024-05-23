<?php

namespace App\Http\Services;

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
}
