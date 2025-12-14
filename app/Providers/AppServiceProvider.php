<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Participant;
use App\Models\Tournament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\ParticipantPolicy;
use App\Policies\TournamentPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('is-admin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Tournament::class, TournamentPolicy::class);
        Gate::policy(Answer::class, AnswerPolicy::class);
        Gate::policy(Participant::class, ParticipantPolicy::class);
    }
}
