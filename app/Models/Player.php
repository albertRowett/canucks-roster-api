<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;

    protected $hidden = [
        'position_id',
        'nationality_id',
        'draft_team_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'jersey_number',
        'date_of_birth',
        'position_id',
        'nationality_id',
        'draft_team_id',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }

    public function draftTeam(): BelongsTo
    {
        return $this->belongsTo(DraftTeam::class);
    }

    public function previousTeams(): BelongsToMany
    {
        return $this->belongsToMany(PreviousTeam::class);
    }
}
