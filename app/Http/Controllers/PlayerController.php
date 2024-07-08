<?php

namespace App\Http\Controllers;

use App\Http\Services\DraftTeamService;
use App\Http\Services\NationalityService;
use App\Http\Services\PositionService;
use App\Http\Services\PreviousTeamService;
use App\Models\Player;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PlayerController extends Controller
{
    protected PositionService $positionService;

    protected NationalityService $nationalityService;

    protected DraftTeamService $draftTeamService;

    protected PreviousTeamService $previousTeamService;

    public function __construct(PositionService $positionService, NationalityService $nationalityService, DraftTeamService $draftTeamService, PreviousTeamService $previousTeamService)
    {
        $this->positionService = $positionService;
        $this->nationalityService = $nationalityService;
        $this->draftTeamService = $draftTeamService;
        $this->previousTeamService = $previousTeamService;
    }

    public function getPlayers(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'removed' => 'nullable|boolean',
                'position' => 'nullable|string|in:Goaltender,Defense,Center,Left wing,Right wing',
                'nationality' => 'nullable|string|exists:nationalities,name',
            ]);
            $removed = $request->removed;
            $position = $request->position;
            $nationality = $request->nationality;

            $query = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team']);

            if ($removed) {
                $query->onlyTrashed();
            }

            if ($position) {
                $positionId = $this->positionService->getPositionIdByPositionName($position);
                $query->where('position_id', $positionId);
            }

            if ($nationality) {
                $nationalityId = $this->nationalityService->getNationalityIdByNationalityName($nationality);
                $query->where('nationality_id', $nationalityId);
            }

            $players = $query->get()->makeHidden(['deleted_at']);
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        return response()->json([
            'data' => $players,
            'message' => 'Players successfully retrieved',
        ]);
    }

    public function getPlayerByJerseyNumber(int $jerseyNumber): JsonResponse
    {
        try {
            $player = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team'])->where('jersey_number', $jerseyNumber)->withTrashed()->first();
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        if (is_null($player)) {
            return $this->returnPlayerNotFoundResponse($jerseyNumber);
        }

        return response()->json([
            'data' => $player,
            'message' => 'Player successfully retrieved',
        ]);
    }

    public function addPlayer(Request $request): JsonResponse
    {
        try {
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

            DB::transaction(function () use ($request) {
                $name = $request->name;
                $jerseyNumber = $request->jerseyNumber;
                $dateOfBirth = $request->dateOfBirth;
                $positionId = $this->positionService->getPositionIdByPositionName($request->position);
                $nationalityId = $this->nationalityService->getNationalityIdByNationalityName($request->nationality);

                if (is_null($request->draftTeam)) {
                    $draftTeamId = null;
                } else {
                    $draftTeamId = $this->draftTeamService->getDraftTeamIdByDraftTeamName($request->draftTeam);
                }

                if (is_null($request->previousTeams)) {
                    $previousTeamIds = null;
                } else {
                    $previousTeamIds = $this->previousTeamService->getPreviousTeamIdsByPreviousTeamNames($request->previousTeams);
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

    public function updatePlayer(int $jerseyNumber, Request $request): JsonResponse
    {
        try {
            $player = Player::with(['position', 'nationality', 'draftTeam.team', 'previousTeams.team'])->where('jersey_number', $jerseyNumber)->withTrashed()->first();

            if (is_null($player)) {
                return $this->returnPlayerNotFoundResponse($jerseyNumber);
            }

            if (! $request->hasAny(['name', 'jerseyNumber', 'dateOfBirth', 'position', 'nationality', 'draftTeam', 'previousTeams'])) {
                return response()->json([
                    'message' => 'A minimum of 1 data field is required',
                ], 422);
            }

            $request->validate([
                'name' => 'string|max:255',
                'jerseyNumber' => ['numeric', 'integer', 'between:1,99', Rule::unique('players', 'jersey_number')->ignore($jerseyNumber, 'jersey_number')],
                'dateOfBirth' => 'date_format:Y-m-d',
                'position' => 'string|in:Goaltender,Defense,Center,Left wing,Right wing',
                'nationality' => 'string|max:255',
                'draftTeam' => 'nullable|string|max:255',
                'previousTeams' => 'nullable|array',
                'previousTeams.*' => 'string|max:255|distinct',
            ]);

            if ($request->has('name')) {
                $player->name = $request->name;
            }

            if ($request->has('jerseyNumber')) {
                $player->jersey_number = $request->jerseyNumber;
            }

            if ($request->has('dateOfBirth')) {
                $player->date_of_birth = $request->dateOfBirth;
            }

            DB::transaction(function () use ($request, $player) {
                if ($request->has('position')) {
                    $positionId = $this->positionService->getPositionIdByPositionName($request->position);
                    $player->position_id = $positionId;
                }

                if ($request->has('nationality')) {
                    $nationalityId = $this->nationalityService->getNationalityIdByNationalityName($request->nationality);
                    $player->nationality_id = $nationalityId;
                }

                if ($request->has('draftTeam')) {
                    $draftTeamId = is_null($request->draftTeam) ? null : $this->draftTeamService->getDraftTeamIdByDraftTeamName($request->draftTeam);
                    $player->draft_team_id = $draftTeamId;
                }

                $player->save();

                if ($request->has('previousTeams')) {
                    $previousTeamIds = is_null($request->previousTeams) ? null : $this->previousTeamService->getPreviousTeamIdsByPreviousTeamNames($request->previousTeams);
                    $player->previousTeams()->sync($previousTeamIds);
                }
            });
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        return response()->json([
            'message' => 'Player updated',
        ]);
    }

    public function changePlayerStatus(int $jerseyNumber, Request $request): JsonResponse
    {
        try {
            $player = Player::where('jersey_number', $jerseyNumber)->withTrashed()->first();

            if (is_null($player)) {
                return $this->returnPlayerNotFoundResponse($jerseyNumber);
            }

            $request->validate(['action' => 'required|in:remove,restore']);
            $action = $request->action;

            $statusCode = 200;

            if ($action === 'remove') {
                if ($player->trashed()) {
                    $message = 'Player already removed from roster';
                    $statusCode = 400;
                } else {
                    $player->delete();
                    $message = 'Player removed from roster';
                }
            } else {
                if ($player->trashed()) {
                    $player->restore();
                    $message = 'Player restored to roster';
                } else {
                    $message = 'Player already on roster';
                    $statusCode = 400;
                }
            }
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    public function deletePlayer(int $jerseyNumber): JsonResponse
    {
        $query = Player::where('jersey_number', $jerseyNumber);

        try {
            if ($query->exists()) {
                $query->forceDelete();
            } else {
                return $this->returnPlayerNotFoundResponse($jerseyNumber);
            }
        } catch (QueryException $e) {
            return $this->returnUnexpectedErrorResponse();
        }

        return response()->json([
            'message' => 'Player deleted',
        ]);
    }

    private function returnUnexpectedErrorResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Unexpected error occurred',
        ], 500);
    }

    private function returnPlayerNotFoundResponse($jerseyNumber): JsonResponse
    {
        return response()->json([
            'message' => "Player with jersey number $jerseyNumber not found",
        ], 404);
    }
}
