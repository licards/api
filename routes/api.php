<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeckController;
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
        $api->resource('categories', CategoryController::class);
        $api->resource('decks', DeckController::class);
    });
});