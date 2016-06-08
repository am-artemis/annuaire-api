<?php

namespace App\Http\Controllers;

use App\Models\Social;

class SocialController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = [];

    /**
     * Display a listing of the resource.
     *
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
