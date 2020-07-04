<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Reviews\Review;
use App\Models\Team;
use App\Models\User;
use App\Policies\ReviewPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $gate = $this->app->make(Gate::class);

        $gate->policy(User::class, UserPolicy::class);
        $gate->policy(Review::class, ReviewPolicy::class);
        $gate->policy(Team::class, TeamPolicy::class);
    }
}
