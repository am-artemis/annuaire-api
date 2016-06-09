<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\ResponsibilityStoreRequest;
use Illuminate\Http\ResponsibilityUpdateRequest;
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
        return Responsibility::paginate($request->input('items', 30));;
    }

    /**
     * Display the specified resource.
     *
     * @param Responsibility $responsibility
     * @return Response
     */
    public function show(Responsibility $responsibility)
    {
        return $responsibility;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ResponsibilityStoreRequest $request)
    {
        $responsibilityArray = $request->only(['user_id', 'campus_id', 'title', 'strass', 'from', 'to']);

        $responsibility = Responsibility::forceCreate($responsibilityArray);

        return $this->response->created(null, $responsibility);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Responsibility $responsibility
     * @return Response
     */
    public function update(ResponsibilityUpdateRequest $request, Responsibility $responsibility)
    {
        $responsibilityArray = $request->only(['campus_id', 'title', 'strass', 'from', 'to']);

        $responsibility->update($responsibilityArray);

        return $this->response->accepted(null, $responsibility);
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

        return $this->response->noContent();
    }
}
