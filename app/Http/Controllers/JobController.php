<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\JobTransformer;
use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;

use App\Models\Job;

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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Job::paginate($request->input('items', 30));;
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     * @return Response
     */
    public function show(Job $job)
    {
        return $job;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(JobStoreRequest $request)
    {
        $jobArray = $request->only(['user_id', 'title', 'description', 'from', 'to']);

        $job = Job::forceCreate($jobArray);

        return $this->response->created(null, $job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $job
     * @return Response
     */
    public function update(JobUpdateRequest $request, Job $job)
    {
        $jobArray = $request->only(['title', 'description', 'from', 'to']);

        $job->update($jobArray);

        return $this->response->accepted(null, $job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return Response
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return $this->response->noContent();
    }
}
