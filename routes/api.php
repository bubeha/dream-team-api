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
    /** @uses \App\Http\Controllers\Api\ReviewController::getFeedForEmployee() */
    $router->get('feed', 'ReviewController@getFeedForEmployee');
    $router->get('feed/size/{size}', 'ReviewController@getFeedForEmployee');
    /** @uses \App\Http\Controllers\Api\ReviewController::show() */
    $router->get('feed/{feedId}', 'ReviewController@show');
    /** @uses \App\Http\Controllers\Api\UserController::getListOfUsers() */
    $router->get('users', 'UserController@getListOfUsers');
    /** @uses \App\Http\Controllers\Api\UserController::getUserFeed() */
    $router->get('users/{userId}/feed', 'UserController@getUserFeed');
});
