<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PreviousTeam extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'team_id',
        'created_at',
        'updated_at',
        'pivot',
    ];

    protected $fillable = ['team_id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }
}
