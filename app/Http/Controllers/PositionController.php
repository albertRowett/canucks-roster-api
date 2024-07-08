<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function getPositions(): JsonResponse
    {
        try {
            $positions = Position::all();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Unexpected error occurred',
            ], 500);
        }

        return response()->json([
            'data' => $positions,
            'message' => 'Positions successfully retrieved',
        ]);
    }
}
