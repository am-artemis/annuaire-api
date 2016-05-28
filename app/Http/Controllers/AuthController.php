<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthStoreRequest;
use App\Models\User;
use Socialite;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    /**
     * @param \Tymon\JWTAuth\JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
        $this->middleware('jwt.refresh', ['only' => ['update']]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $providerUser = Socialite::driver('google')->stateless()->user();
        return $this->store($providerUser->email);
    }
    public function store($email)
    {
        try {
            // attempt to verify the credentials and create a token for the user
            $user = User::whereEmail($email)->first();
            if (!$user) {
                $this->response->error('Bad credentials.', 401);
            }
            $token = $this->auth->fromUser($user);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            $this->response->error('Could not create token.', 500);
        }

        return response()->json(compact('user', 'token'));
    }

    public function update()
    {
        return response(null, 204);
    }
}
