<?php

namespace App\Http\Controllers;

use App\Campus;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Campus::all();
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        return Campus::findOrFail($id);
    }
}
