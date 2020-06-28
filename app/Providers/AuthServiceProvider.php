<?php

namespace App\Providers;

use App\Models\Review;
use App\Models\User;
use App\Policies\ReviewPolicy;
use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

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
    }
}
