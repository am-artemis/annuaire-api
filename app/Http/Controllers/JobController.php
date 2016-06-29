<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\JobTransformer;
use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;

use App\Models\Job;

class JobController extends Controller
{

    private static $relationships = [];

    public function index(Request $request)
    {
        return Job::paginate($request->input('items', 30));;
    }

    public function show(Job $job)
    {
        return $job;
    }

    public function store(JobStoreRequest $request)
    {
        $jobArray = $request->intersect(['user_id', 'title', 'description', 'from', 'to']);

        $job = Job::forceCreate($jobArray);

        return $this->response->created(null, $job);
    }

    public function update(JobUpdateRequest $request, Job $job)
    {
        $jobArray = $request->intersect(['title', 'description', 'from', 'to']);

        $job->update($jobArray);

        return $this->response->accepted(null, $job);
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return $this->response->noContent();
    }
}
