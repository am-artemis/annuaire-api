<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\ResponsibilityTransformer;

use App\Models\Responsibility;

class ResponsibilityController extends Controller
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
        $responsibilities = Responsibility::with(self::$relationships)->paginate($request->input('items', 30));

        return $responsibilities;
    }

    /**
     * Display the specified resource.
     *
     * @param Responsibility $responsibility
     * @return Response
     */
    public function show(Responsibility $responsibility)
    {
        return $responsibility->load(self::$relationships);
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
     * @param Responsibility $responsibility
     * @return Response
     */
    public function update(Request $request, Responsibility $responsibility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Responsibility $responsibility
     * @return Response
     */
    public function destroy(Responsibility $responsibility)
    {
        $responsibility->delete();
    }
}
