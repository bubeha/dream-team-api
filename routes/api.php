<?php

/**
 * @var Laravel\Lumen\Routing\Router $router
 */
/** @uses \App\Http\Controllers\Api\AuthController::login() */
$router->post('login', 'AuthController@login');

$router->group([
    'middleware' => 'auth',
], static function () use ($router) {
    /** @uses \App\Http\Controllers\Api\AuthController::logout() */
    $router->post('logout', 'AuthController@logout');
    /** @uses \App\Http\Controllers\Api\AuthController::getCurrentUserData() */
    $router->post('me', 'AuthController@getCurrentUserData');
    /** @uses \App\Http\Controllers\Api\FeedController::getFeedForEmployee() */
    $router->get('feed', 'FeedController@getFeedForEmployee');
});
