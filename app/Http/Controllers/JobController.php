<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Transformers\JobTransformer;

use App\Models\Job;

class JobController extends Controller
{

    private static $relationships = [];

    public function index(Request $request)
    {
        $jobs = Job::with(self::$relationships)->paginate($request->input('items', 30));

        return $jobs;
    }

    public function show(Job $job)
    {
        return $job->load(self::$relationships);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Job $job)
    {
        //
    }

    public function destroy(Job $job)
    {
        $job->delete();
    }
}
