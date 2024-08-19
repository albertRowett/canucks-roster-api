<?php

namespace App\Http\Services;

use App\Models\Nationality;

class NationalityService
{
    public function getNationalityIdByNationalityName(string $name): int
    {
        $nationality = Nationality::firstOrCreate(['name' => $name]);

        return $nationality->id;
    }
}
