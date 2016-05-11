<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\DegreeTransformer;

use App\Models\Degree;

class DegreeController extends Controller
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $degrees = Degree::with(self::$relationships)->paginate($request->input('items', 30));

        return $degrees;
    }

    /**
     * Display the specified resource.
     *
     * @param Degree $degree
     * @return Response
     */
    public function show(Degree $degree)
    {

        return $degree->load(self::$relationships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Degree $degree
     * @return Response
     */
    public function update(Request $request, Degree $degree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degree $degree
     */
    public function destroy(Degree $degree)
    {
        $degree->delete();
    }
}
