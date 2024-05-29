<?php

namespace App\Http\Services;

use App\Models\Position;

class PositionService
{
    public function getPositionIdByPositionName(string $name): int
    {
        $position = Position::firstOrCreate([
            'name' => $name,
        ]);

        return $position->id;
    }
}
