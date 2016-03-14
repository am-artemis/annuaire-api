<?php

namespace App\Http\Controllers;

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
        return User::all();
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }
}
