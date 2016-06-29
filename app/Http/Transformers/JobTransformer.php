<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Job;

class JobTransformer extends BaseTransformer
{
    public function transform(Job $job)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.jobs.show', [$job->user_id, $job->id]),
            'title' => $job->title,
            'description' => $job->description,
            'from'        => $job->from->format('Y-m-d'),
            'to'          => is_null($job->to) ? null : $job->to->format('Y-m-d'),
        ];

        return $data;
    }
}
