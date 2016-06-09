<?php
use Dingo\Api\Routing\Router;

Route::singularResourceParameters();
Route::get('/', ['as' => 'home', function () {
    return app()->version();
}]);

/*
|--------------------------------------------------------------------------
| API Transformers
|--------------------------------------------------------------------------
*/

app('Dingo\Api\Transformer\Factory')->register('App\Models\User', 'App\Http\Transformers\UserTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Campus', 'App\Http\Transformers\CampusTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Photo', 'App\Http\Transformers\PhotoTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Address', 'App\Http\Transformers\AddressTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Residence', 'App\Http\Transformers\ResidenceTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Course', 'App\Http\Transformers\CourseTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Degree', 'App\Http\Transformers\DegreeTransformer');
app('Dingo\Api\Transformer\Factory')->register('App\Models\Responsibility', 'App\Http\Transformers\ResponsibilityTransformer');
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

$api = app(Router::class);
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function (Router $api) {

    $api->get('/auth', ['as' => 'auth.redirect', 'uses' => 'AuthController@redirectToProvider']);
    $api->put('/auth', ['as' => 'auth.refresh', 'uses' => 'AuthController@refresh']);
    $api->any('/auth/callback', ['as' => 'auth.callback', 'uses' => 'AuthController@handleProviderCallback']);

    //$api->group(['middleware' => 'jwt.auth'], function (Router $api) {
    $api->group([], function (Router $api) {

        // Ressources statiques
        $api->resources([
            'campuses'         => ['CampusController', ['only' => ['index', 'show']]],
            'residences'       => ['ResidenceController', ['only' => ['index', 'show']]],
            'socials'          => ['SocialController', ['only' => ['index', 'show']]],
            'search'           => ['SearchController', ['only' => ['index']]],
        ]);

        // Ressources dynamiques
        $api->resources([
            'users'            => ['UserController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'photos'           => ['PhotoController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'addresses'        => ['AddressController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'courses'          => ['CourseController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'degrees'          => ['DegreeController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'responsibilities' => ['ResponsibilityController', ['only' => ['index', 'show']]],
            'jobs'             => ['JobController', ['only' => ['index', 'show', 'store', 'update', 'destroy    ']]],
        ]);

        // Resources nestées
        $api->resources([
            'users.socials'          => ['UserSocialController', ['only' => ['index', 'show', 'store', 'destroy']]],
            'users.photos'           => ['UserPhotoController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'users.addresses'        => ['UserAddressController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'users.residences'       => ['UserResidenceController', ['only' => ['index', 'show', 'store', 'destroy']]],
            'users.courses'          => ['UserCourseController', ['only' => ['index', 'show', 'store', 'destroy']]],
            'users.responsibilities' => ['UserResponsibilityController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]],
            'campuses.users'         => ['CampusUserController', ['only' => ['index']]],
        ]);
    });
});
