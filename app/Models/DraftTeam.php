<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DraftTeam extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'team_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = ['team_id'];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
