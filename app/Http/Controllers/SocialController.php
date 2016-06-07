<?php

namespace App\Http\Controllers;

use App\Models\Social;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        return Social::all();
    }

    /**
     * Display the specified resource.
     *
     * @param Social $social
     * @return Response
     */
    public function show(Social $social)
    {
        return $social;
    }
}
