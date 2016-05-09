<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\CursusTransformer;

use App\Models\Cursus;

class CursusController extends Controller
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
        $cursus = Cursus::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($cursus, new CursusTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param Cursus $cursus
     * @return Response
     */
    public function show(Cursus $cursus)
    {

        return $this->response->item($cursus->load(self::$relationships), new CursusTransformer);
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
     * @param Cursus $cursus
     * @return Response
     */
    public function update(Request $request, Cursus $cursus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cursus $cursus
     * @return Response
     */
    public function destroy(Cursus $cursus)
    {
        $cursus->delete();
    }
}
