<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
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
        return Degree::paginate($request->input('items', 30));
    }

    /**
     * Display the specified resource.
     *
     * @param Degree $degree
     * @return Response
     */
    public function show(Degree $degree)
    {
        return $degree;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $degreeArray = $request->only(['title', 'school', 'am']);

        if ($request->has('am') && $degreeArray['am'] == true) {
            $degreeArray['am'] = 1;
            $degreeArray['school'] = null;
        } else {
            $degreeArray['am'] = 0;
        }

        $degree = Degree::forceCreate($degreeArray);

        return $this->response->created(null, $degree);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Degree $degree
     * @return Response
     */
    public function update(Request $request, Degree $degree)
    {
        $degreeArray = $request->only(['title', 'school', 'am']);

        if ($request->has('am') && $degreeArray['am'] == true) {
            $degreeArray['am'] = 1;
            $degreeArray['school'] = null;
        } else {
            $degreeArray['am'] = 0;
        }

        $degree->update($degreeArray);

        return $this->response->accepted(null, $degree);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Degree $degree
     */
    public function destroy(Degree $degree)
    {
        $degree->delete();

        return $this->response->noContent();
    }
}
