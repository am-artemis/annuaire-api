<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Transformers\ResidenceTransformer;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $residences = Residence::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($residences, new ResidenceTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $residence
     * @return Response
     */
    public function show(Residence $residence)
    {
        return $this->response->item($residence->load(self::$relationships), new ResidenceTransformer);
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
     * @param Residence $residence
     * @return Response
     */
    public function destroy(Residence $residence)
    {
        $residence->delete();
    }
}
