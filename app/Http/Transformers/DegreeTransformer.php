<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Degree;

class DegreeTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Degree $degree
     * @return array
     */
    public function transform(Degree $degree)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('degrees.show', $degree->id),
            'title' => $degree->title,
            'school' => $degree->school,
            'am' => (bool) $degree->am ? true : false,
        ];

        if (isset($degree->pivot)) {
            $data['pivot'] = [
                'year' => (int) $degree->pivot->year,
            ];
        }

        return $data;
    }
}
