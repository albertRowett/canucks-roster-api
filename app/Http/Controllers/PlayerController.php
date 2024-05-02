<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function getPlayers()
    {
        $players = Player::with(['position', 'nationality', 'draft_team.team', 'previous_teams.team'])->get();

        return response()->json([
            'data' => $players,
            'message' => 'Players successfully retrieved'
        ]);
    }
}
