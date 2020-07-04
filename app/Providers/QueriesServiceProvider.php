<?php

declare(strict_types=1);

namespace App\Providers;

use App\Queries\EloquentReviewQueries;
use App\Queries\Profile\EloquentProfileQueries;
use App\Queries\Profile\ProfileQueries;
use App\Queries\ReviewQueries;
use App\Queries\Team\EloquentTeamQueries;
use App\Queries\Team\TeamQueries;
use App\Queries\User\EloquentUserQueries;
use App\Queries\User\UserQueries;
use Illuminate\Support\ServiceProvider;

/**
 * Class QueriesServiceProvider
 * @package App\Providers
 */
class QueriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ReviewQueries::class, EloquentReviewQueries::class);
        $this->app->bind(UserQueries::class, EloquentUserQueries::class);
        $this->app->bind(ProfileQueries::class, EloquentProfileQueries::class);
        $this->app->bind(TeamQueries::class, EloquentTeamQueries::class);
    }
}
