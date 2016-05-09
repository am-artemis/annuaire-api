<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Resam;

class ResamTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Resam $resam
     * @return array
     */
    public function transform(Resam $resam)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('resams.show', $resam->id),
            'name' => $resam->name,
            'address' => $resam->address,
            'lat' => $resam->lat,
            'lng' => $resam->lng,
            'campus' => [
                'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $resam->campus->id),
                'short' => $resam->campus->short,
            ],
        ];

        if (isset($resam->pivot)) {
            $data['pivot'] = [
                'room' => $resam->pivot->room,
                'from' => $resam->pivot->from,
                'to' => $resam->pivot->to,
            ];
        }

        return $data;
    }
}
