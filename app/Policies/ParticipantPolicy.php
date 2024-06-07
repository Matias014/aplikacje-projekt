<?php

namespace App\Policies;

use App\Models\Participant;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ParticipantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Participant $participant): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Tournament $tournament): bool
    {
        return $user->role == 'admin' || Auth::user()->id == $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Participant $participant): bool
    {
        return $user->role == 'admin' || $user->id === $participant->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Participant $participant, Tournament $tournament): bool
    {
        return ($user->role == 'admin' || $user->id === $participant->user_id) && $tournament->date > now();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Participant $participant): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Participant $participant): bool
    {
        return $user->role == 'admin';
    }
}
