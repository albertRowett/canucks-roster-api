<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class NationalityController extends Controller
{
    public function getNationalities(): JsonResponse
    {
        try {
            $nationalities = Nationality::all();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Unexpected error occurred',
            ], 500);
        }

        return response()->json([
            'data' => $nationalities,
            'message' => 'Nationalities successfully retrieved',
        ]);
    }
}
