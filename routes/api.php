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

    $router->group(['prefix' => 'feed'], static function () use ($router) {
        /** @uses \App\Http\Controllers\Api\ReviewController::getFeedForEmployee() */
        $router->get('/', 'ReviewController@getFeedForEmployee');
        $router->get('/size/{size}', 'ReviewController@getFeedForEmployee');
        /** @uses \App\Http\Controllers\Api\ReviewController::show() */
        $router->get('/{feedId}', 'ReviewController@show');
    });

    $router->group(['prefix' => 'users'], static function () use ($router) {
        /** @uses \App\Http\Controllers\Api\UserController::getUsersWithPagination() */
        $router->get('/', 'UserController@getUsersWithPagination');
        /** @uses \App\Http\Controllers\Api\UserController::getUserFeed() */
        $router->get('/{userId}/feed', 'UserController@getUserFeed');
        /** @uses \App\Http\Controllers\Api\UserController::getListOfUsers() */
        $router->get('/list', 'UserController@getListOfUsers');
        /** @uses \App\Http\Controllers\Api\UserController::getDataForFilter() */
        $router->get('/filter-data', 'UserController@getDataForFilter');
        /** @uses \App\Http\Controllers\Api\UserController::getUser() */
        $router->get('/{userId}', 'UserController@getUser');
        /** @uses \App\Http\Controllers\Api\ReviewController::addNewReviewToUser() */
        $router->post('/{userId}/reviews', 'ReviewController@addNewReviewToUser');
    });

    $router->group(['prefix' => 'teams'], static function () use ($router) {
        /** @uses \App\Http\Controllers\Api\TeamController::getTeams() */
        $router->get('/', 'TeamController@getTeams');
        /** @uses \App\Http\Controllers\Api\TeamController::showTeam() */
        $router->get('/{id}', 'TeamController@showTeam');
        /** @uses \App\Http\Controllers\Api\TeamController::createTeam() */
        $router->post('/', 'TeamController@createTeam');
        /** @uses \App\Http\Controllers\Api\TeamController::updateTeam() */
        $router->put('/{id}', 'TeamController@updateTeam');
        /** @uses \App\Http\Controllers\Api\TeamController::deleteTeam() */
        $router->delete('/{id}', 'TeamController@deleteTeam');
    });

    /** @uses \App\Http\Controllers\Api\AnaliseController::usersAnalise() */
    $router->post('analise/users', 'AnaliseController@usersAnalise');
});
