<?php

namespace App\Http\Controllers;

use App\Models\Player;

class PlayerController extends Controller
{
    public function getPlayers()
    {
        $players = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team'])->get();

        if ($players->isEmpty()) {
            return response()->json([
                'message' => 'No players found',
            ], 404);
        }

        return response()->json([
            'data' => $players,
            'message' => 'Players successfully retrieved',
        ]);
    }
}
