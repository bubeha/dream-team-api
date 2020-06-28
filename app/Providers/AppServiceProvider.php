<?php

namespace App\Providers;

use App\Queries\EloquentReviewQueries;
use App\Queries\ReviewQueries;
use App\Queries\User\EloquentUserQueries;
use App\Queries\User\UserQueries;
use App\Services\QueryModifier\Feed\FeedQueryModifier;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Queries
        $this->app->bind(ReviewQueries::class, EloquentReviewQueries::class);
        $this->app->bind(UserQueries::class, EloquentUserQueries::class);

        // Modifiers
        $this->app->bind(FeedQueryModifierContract::class, FeedQueryModifier::class);
    }
}
