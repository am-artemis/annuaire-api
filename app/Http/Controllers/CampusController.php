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
     * @param Request $request
     * @return \Dingo\Api\Http\Response\
     */
    public function index(Request $request)
    {
        $campuses = Campus::with(self::$relationships)->paginate($request->input('items', 30));

        return $campuses;
    }

    /**
     * Display the specified resource.
     * @param Campus $campus
     * @return \Dingo\Api\Http\Response
     */
    public function show(Campus $campus)
    {
        return $campus->load(self::$relationships);
    }
}
