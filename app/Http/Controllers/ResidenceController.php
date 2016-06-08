<?php

namespace App\Http\Controllers;

use App\Models\Residence;

class ResidenceController extends Controller
{
    /**
     * List of relationships to load.
     *
     * @var array
     */
    private static $relationships = ['campus'];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Residence::with(self::$relationships)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $residence
     * @return Response
     */
    public function show(Residence $residence)
    {
        return $residence->load(self::$relationships);
    }
}
