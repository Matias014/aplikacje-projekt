<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'date', 'price', 'img', 'max_participants'];

    public $timestamps = false;

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants')->withPivot('team');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
