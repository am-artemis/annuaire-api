<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Bouls;

class BoulsTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Bouls $bouls)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('bouls.show', $bouls->id),
            'title' => $bouls->title,
            'strass' => $bouls->strass,
            'from' => is_null($bouls->from) ? null : $bouls->from->format('Y-m-d'),
            'to' => is_null($bouls->to) ? null : $bouls->to->format('Y-m-d'),
            'campus' => [
                    'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $bouls->campus->id),
                    'short' => $bouls->campus->short,
                    'name' => $bouls->campus->name,
                ],
        ];

        return $data;
    }
}
