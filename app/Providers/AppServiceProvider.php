<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\QueryModifier\Feed\FeedQueryModifier;
use App\Services\QueryModifier\Feed\FeedQueryModifierContract;
use App\Services\QueryModifier\User\UserListQueryModifier;
use App\Services\QueryModifier\User\UserListQueryModifierContract;
use App\Services\QueryModifier\User\UserQueryModifier;
use App\Services\QueryModifier\User\UserQueryModifierContract;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(FeedQueryModifierContract::class, FeedQueryModifier::class);
        $this->app->bind(UserListQueryModifierContract::class, UserListQueryModifier::class);
        $this->app->bind(UserQueryModifierContract::class, UserQueryModifier::class);
    }
}
