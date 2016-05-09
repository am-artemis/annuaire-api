<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\CampusTransformer;

use App\Models\Campus;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $campuses = Campus::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->array($campuses, new CampusTransformer);
    }

    /**
     * Display the specified resource.
     * @param Campus $campus
     * @return
     */
    public function show(Campus $campus)
    {
        return $this->response->item($campus->load(self::$relationships), new CampusTransformer);
    }
}
