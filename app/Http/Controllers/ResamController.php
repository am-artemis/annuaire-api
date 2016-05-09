<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Transformers\ResamTransformer;

use App\Models\Resam;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $resams = Resam::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($resams, new ResamTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param Resam $resam
     * @return Response
     */
    public function show(Resam $resam)
    {
        return $this->response->item($resam->load(self::$relationships), new ResamTransformer);
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
     * @param    int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resam $resam
     * @return Response
     */
    public function destroy(Resam $resam)
    {
        $resam->delete();
    }
}
