<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\BoulsTransformer;

use App\Bouls;

class BoulsController extends Controller
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
    public function index(Request $request)
    {
        $bouls = Bouls::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($bouls, new BoulsTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $bouls = Bouls::with(self::$relationships)->findOrFail($id);

        return $this->response->item($bouls, new BoulsTransformer);
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
        Bouls::findOrFail($id)->delete();
    }
}
