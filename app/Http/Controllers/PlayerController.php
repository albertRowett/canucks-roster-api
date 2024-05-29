<?php

namespace App\Http\Controllers;

use App\Http\Services\PlayerService;
use App\Models\Player;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    protected PlayerService $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

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

    public function addPlayer(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jerseyNumber' => 'required|numeric|integer|between:1,99|unique:players,jersey_number',
            'dateOfBirth' => 'required|date_format:Y-m-d',
            'position' => 'required|string|in:Goaltender,Defense,Center,Left wing,Right wing',
            'nationality' => 'required|string|max:255',
            'draftTeam' => 'nullable|string|max:255',
            'previousTeams' => 'nullable|array',
            'previousTeams.*' => 'string|max:255|distinct',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $name = $request->name;
                $jerseyNumber = $request->jerseyNumber;
                $dateOfBirth = $request->dateOfBirth;
                $positionId = $this->playerService->getPositionIdByPositionName($request->position);
                $nationalityId = $this->playerService->getNationalityIdByNationalityName($request->nationality);

                if (is_null($request->draftTeam)) {
                    $draftTeamId = null;
                } else {
                    $draftTeamId = $this->playerService->getDraftTeamIdByDraftTeamName($request->draftTeam);
                }

                if (is_null($request->previousTeams)) {
                    $previousTeamIds = null;
                } else {
                    $previousTeamIds = $this->playerService->getPreviousTeamIdsByPreviousTeamNames($request->previousTeams);
                }

                $player = Player::create([
                    'name' => $name,
                    'jersey_number' => $jerseyNumber,
                    'date_of_birth' => $dateOfBirth,
                    'position_id' => $positionId,
                    'nationality_id' => $nationalityId,
                    'draft_team_id' => $draftTeamId,
                ]);

                if (! is_null($previousTeamIds)) {
                    $player->previousTeams()->attach($previousTeamIds);
                }
            });
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        return response()->json([
            'message' => 'Player added',
        ], 201);
    }

    private function returnUnexpectedErrorResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Unexpected error occurred',
        ], 500);
    }
}
