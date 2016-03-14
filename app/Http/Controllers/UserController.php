<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\UserTransformer;

use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(30);

        return $this->response->paginator($users, new UserTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->item($user, new UserTransformer);
    }
}
