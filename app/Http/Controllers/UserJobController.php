<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use Dingo\Api\Contract\Http\Request;
use App\Http\Requests\UserJobStoreRequest;
use App\Http\Requests\UserJobUpdateRequest;

class UserJobController extends Controller
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
     *
     * @return Response
     */
    public function index(User $user)
    {
        return $user->jobs;
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     *
     * @return Response
     */
    public function show(User $user, $job_id)
    {
        return $user->jobs()->find($job_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(UserJobStoreRequest $request, User $user)
    {
        $jobArray = $request->intersect(['title', 'description', 'from', 'to']);

        $job = new Job($jobArray);

        $user->jobs()->save($job);

        return $this->response->created(null, $user->jobs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $job
     *
     * @return Response
     */
    public function update(UserJobUpdateRequest $request, $user_id, Job $job)
    {
        if ($job->user_id != $user_id) {
            return $this->response->errorBadRequest();
        }

        $jobArray = $request->intersect(['title', 'description', 'from', 'to']);

        $job->update($jobArray);

        return $this->response->accepted(null, $job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     */
    public function destroy(Job $job)
    {
        $job->delete();
        
        return $this->response->noContent();
    }
}
