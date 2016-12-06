<?php

namespace App\Http\Transformers;

use App\Models\Degree;

class DegreeTransformer extends BaseTransformer
{
    public function transform(Degree $degree)
    {
        $data = [
            'self'   => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('degrees.show', $degree->id),
            'title'  => $degree->title,
            'school' => $degree->school,
            'am'     => (bool)$degree->am ? true : false,
        ];

        if (isset($degree->pivot)) {
            $data = array_merge($data, [
                'year' => (int)$degree->pivot->year,
            ]);
        }

        return $data;
    }
}
