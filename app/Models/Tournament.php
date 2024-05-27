<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'date', 'price', 'img', 'max_team_alfa', 'max_team_beta', 'max_team_gamma', 'max_team_delta'];

    public $timestamps = false;

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants')->withPivot('team');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function hasReachedMaxTeamSize($team)
    {
        $maxTeamSize = 4; // Maksymalna liczba członków w drużynie
        return $this->participants()->wherePivot('team', $team)->count() >= $maxTeamSize;
    }
}
