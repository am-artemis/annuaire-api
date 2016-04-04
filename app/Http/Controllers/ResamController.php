<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\ResamTransformer;

use App\Resam;

class ResamController extends Controller
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
        $resams = Resam::with(self::$relationships)->paginate(30);

        return $this->response->paginator($resams, new ResamTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $resam = Resam::with(self::$relationships)->findOrFail($id);

        return $this->response->item($resam, new ResamTransformer);
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
        Resam::findOrFail($id)->delete();
    }
}
