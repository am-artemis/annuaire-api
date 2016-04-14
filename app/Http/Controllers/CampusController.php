<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\CampusTransformer;

use App\Campus;

class CampusController extends Controller
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
        $campuses = Campus::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->array($campuses, new CampusTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $campus = Campus::findOrFail($id);

        return $this->response->item($campus, new CampusTransformer);
    }
}
