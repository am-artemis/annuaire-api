<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\BoulsTransformer;

use App\Models\Bouls;

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
     * @param Request $request
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
     * @param Bouls $bouls
     * @return Response
     */
    public function show(Bouls $bouls)
    {
        return $this->response->item($bouls->load(self::$relationships), new BoulsTransformer);
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
     * @param Bouls $bouls
     * @return Response
     */
    public function update(Request $request, Bouls $bouls)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bouls $bouls
     * @return Response
     */
    public function destroy(Bouls $bouls)
    {
        $bouls->delete();
    }
}
