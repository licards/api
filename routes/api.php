<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\GroupController;
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function(Router $api) {
    $api->get('status', function() { return "UP"; });

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('login', "\\App\\Http\\Controllers\\AuthController@login");
        $api->post('register', "\\App\\Http\\Controllers\\AuthController@register");
        $api->post('refresh', ['middleware' => 'jwt.refresh', function() {}]);
    });

    $api->group(['middleware' => 'api.auth'], function(Router $api) {
        $api->resource('categories', CategoryController::class, ['only' => ['index', 'show']]);
        $api->resource('decks', DeckController::class, ['only' => ['index', 'show']]);
        $api->resource('groups', GroupController::class, ['only' => ['index', 'show']]);
    });
});