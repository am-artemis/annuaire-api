<?php

namespace App\Http\Transformers;

use App\Models\Course;

class CourseTransformer extends BaseTransformer
{
    public function transform(Course $course)
    {
        $data = [
            'self'        => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('courses.show', $course->id),
            'title'       => $course->title,
            'description' => $course->description,
            'campus'      => null,
            'school'      => null,
        ];

        // There's not always a campus
        $campusTransformer = app()->make(CampusTransformer::class);

        if ($course->campus) {
            $data['campus'] = $this->itemArray($course->campus, $campusTransformer);
        } else {
            $data['school'] = $course->school;
        }

        if (isset($course->pivot)) {
            $data = array_merge($data, [
                'from' => $course->pivot->from,
                'to'   => $course->pivot->to,
            ]);

            $data['self'] = app('Dingo\Api\Routing\UrlGenerator')
                ->version('v1')
                ->route('users.courses.show', [$course->pivot->user_id, $course->pivot->id]);
        }

        return $data;
    }
}
