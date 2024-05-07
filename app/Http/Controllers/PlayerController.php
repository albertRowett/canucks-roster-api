<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function getPlayers()
    {
        $players = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team'])->get();

        return response()->json([
            'data' => $players,
            'message' => 'Players successfully retrieved'
        ]);
    }
}
