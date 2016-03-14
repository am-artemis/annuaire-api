<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

/*
|--------------------------------------------------------------------------
| API Transformers
|--------------------------------------------------------------------------
*/

app('Dingo\Api\Transformer\Factory')->register('App\User', 'App\Http\Transformers\UserTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Campus', 'App\Http\Transformers\CampusTransformer');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here are the API routes. They are managed by Dingo/API and can be accessed within the application.
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('users/', ['as' => 'users.index', 'uses' => 'App\Http\Controllers\UserController@index']);
    $api->get('users/{id}', ['as' => 'users.show', 'uses' => 'App\Http\Controllers\UserController@show']);

    $api->get('campuses/', ['as' => 'campuses.index', 'uses' => 'App\Http\Controllers\CampusController@index']);
    $api->get('campuses/{id}', ['as' => 'campuses.show', 'uses' => 'App\Http\Controllers\CampusController@show']);
});
