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

app('Dingo\Api\Transformer\Factory')->register('App\Models\User', 'App\Http\Transformers\UserTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Campus', 'App\Http\Transformers\CampusTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Photo', 'App\Http\Transformers\PhotoTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Address', 'App\Http\Transformers\AddressTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Resam', 'App\Http\Transformers\ResamTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Cursus', 'App\Http\Transformers\CursusTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Degree', 'App\Http\Transformers\DegreeTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Bouls', 'App\Http\Transformers\BoulsTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Job', 'App\Http\Transformers\JobTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Social', 'App\Http\Transformers\SocialTransformer');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here are the API routes. They are managed by Dingo/API and can be accessed within the application.
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    // Recherche temporaire
    $api->get('search', ['as' => 'search', 'uses' => 'SearchController@index']);
    
    $api->resources([
        'users' => ['UserController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
        'campuses' => ['CampusController', ['only' => ['index', 'show']]],
        'photos' => ['PhotoController', ['only' => ['index', 'show']]],
        'addresses' => ['AddressController', ['only' => ['index', 'show', 'destroy']]],
        'resams' => ['ResamController', ['only' => ['index', 'show']]],
        'cursus' => ['CursusController', ['only' => ['index', 'show']]],
        'degrees' => ['DegreeController', ['only' => ['index', 'show']]],
        'bouls' => ['BoulsController', ['only' => ['index', 'show']]],
        'jobs' => ['JobController', ['only' => ['index', 'show']]],
        'socials' => ['SocialController', ['only' => ['index', 'show']]],
    ]);
});
