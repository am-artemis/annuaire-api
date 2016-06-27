<?php

namespace App\Http\Controllers;

use App\Models\Campus;

class CampusController extends Controller
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
     * @return \Dingo\Api\Http\Response\
     */
    public function index()
    {
        return Campus::all();
    }

    /**
     * Display the specified resource.
     *
     * @param Campus $campus
     * @return \Dingo\Api\Http\Response
     */
    public function show(Campus $campus)
    {
        return $campus;
    }
}
