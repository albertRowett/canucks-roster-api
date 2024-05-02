<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function draft_team(): HasOne
    {
        return $this->hasOne(DraftTeam::class);
    }

    public function previous_team(): HasOne
    {
        return $this->hasOne(PreviousTeam::class);
    }
}
