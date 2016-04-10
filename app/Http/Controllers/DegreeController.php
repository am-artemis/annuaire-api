<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\DegreeTransformer;

use App\Degree;

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
     * @return Response
     */
    public function index()
    {
        $degrees = Degree::with(self::$relationships)->paginate(30);

        return $this->response->paginator($degrees, new DegreeTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $degree = Degree::with(self::$relationships)->findOrFail($id);

        return $this->response->item($degree, new DegreeTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    int    $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int    $id
     * @return Response
     */
    public function destroy($id)
    {
        Degree::findOrFail($id)->delete();
    }
}
