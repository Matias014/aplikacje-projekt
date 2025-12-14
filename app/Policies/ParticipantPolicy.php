<?php

namespace App\Policies;

use App\Models\Participant;
use App\Models\Tournament;
use App\Models\User;

class ParticipantPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Participant $participant): bool
    {
        return true;
    }

    public function create(User $user, Tournament $tournament): bool
    {
        return $user->role === 'admin' || $tournament->date > now();
    }

    public function update(User $user, Participant $participant): bool
    {
        return $user->role === 'admin' || $user->id === $participant->user_id;
    }

    public function delete(User $user, Participant $participant, Tournament $tournament): bool
    {
        return ($user->role === 'admin' || $user->id === $participant->user_id) && $tournament->date > now();
    }

    public function restore(User $user, Participant $participant): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Participant $participant): bool
    {
        return $user->role === 'admin';
    }
}
