<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Participant;
use App\Models\Tournament;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\AnswerPolicy;
use App\Policies\ParticipantPolicy;
use App\Policies\TournamentPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->afterResolving(EncryptCookies::class, function ($middleware) {
            $middleware->disableFor('laravel_session');
            $middleware->disableFor('XSRF-TOKEN');
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Tournament::class, TournamentPolicy::class);
        Gate::policy(Answer::class, AnswerPolicy::class);
        Gate::policy(Participant::class, ParticipantPolicy::class);
    }
}
