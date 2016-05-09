<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Cursus;

class CursusTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Cursus $cursus
     * @return array
     */
    public function transform(Cursus $cursus)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('cursus.show', $cursus->id),
            'title' => $cursus->title,
            'description' => $cursus->description,
            'campus' => null,
            'school' => null,
        ];

        // There's not always a campus
        if ($cursus->campus) {
            $data['campus'] = [
                'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $cursus->campus->id),
                'short' => $cursus->campus->short,
                'name' => $cursus->campus->name,
            ];
        } else {
            $data['school'] = $cursus->school;
        }

        if (isset($cursus->pivot)) {
            $data['pivot'] = [
                'from' => $cursus->pivot->from,
                'to' => $cursus->pivot->to,
            ];
        }

        return $data;
    }
}
