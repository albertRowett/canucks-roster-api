<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    public function getPlayers(): JsonResponse
    {
        $players = Player::with(['position:id,name', 'nationality:id,name'])->get();

        return response()->json([
            'data' => $players,
            'message' => 'Players successfully retrieved',
        ]);
    }

    public function getPlayerByJerseyNumber(int $jerseyNumber): JsonResponse
    {
        $player = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team'])->where('jersey_number', '=', $jerseyNumber)->get();

        if ($player->isEmpty()) {
            return response()->json([
                'message' => "Player with jersey number $jerseyNumber not found",
            ], 404);
        }

        return response()->json([
            'data' => $player,
            'message' => 'Player successfully retrieved',
        ]);
    }
}
