<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\JobTransformer;

use App\Job;

class JobController extends Controller
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
        $jobs = Job::with(self::$relationships)->paginate($request->input('items', 30))->appends($request->except('page'));

        return $this->response->paginator($jobs, new JobTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param    int    $id
     * @return Response
     */
    public function show($id)
    {
        $jobs = Job::with(self::$relationships)->findOrFail($id);

        return $this->response->item($jobs, new JobTransformer);
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
        Job::findOrFail($id)->delete();
    }
}
