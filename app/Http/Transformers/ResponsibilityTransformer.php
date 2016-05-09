<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Responsibility;

class ResponsibilityTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Responsibility $responsibility
     * @return array
     */
    public function transform(Responsibility $responsibility)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('responsibilities.show', $responsibility->id),
            'title' => $responsibility->title,
            'strass' => $responsibility->strass,
            'from' => is_null($responsibility->from) ? null : $responsibility->from->format('Y-m-d'),
            'to' => is_null($responsibility->to) ? null : $responsibility->to->format('Y-m-d'),
            'campus' => [
                    'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $responsibility->campus->id),
                    'short' => $responsibility->campus->short,
                    'name' => $responsibility->campus->name,
                ],
        ];

        return $data;
    }
}
