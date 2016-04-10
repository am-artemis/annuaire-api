<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Job;

class JobTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Job $job)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('jobs.show', $job->id),
            'title' => $job->title,
            'description' => $job->description,
            'from' => is_null($job->from) ? null : $job->from->format('Y-m-d'),
            'to' => is_null($job->to) ? null : $job->to->format('Y-m-d'),
        ];

        return $data;
    }
}
