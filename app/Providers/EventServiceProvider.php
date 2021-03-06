<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ReviewChangesEvent;
use App\Listeners\ChangeUserRatingListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ReviewChangesEvent::class => [
            ChangeUserRatingListener::class,
        ],
    ];
}
