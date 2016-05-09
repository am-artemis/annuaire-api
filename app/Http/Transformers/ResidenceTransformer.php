<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Residence;

class ResidenceTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Residence $Residence
     * @return array
     */
    public function transform(Residence $Residence)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('residences.show', $Residence->id),
            'name' => $Residence->name,
            'address' => $Residence->address,
            'lat' => $Residence->lat,
            'lng' => $Residence->lng,
            'campus' => [
                'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $Residence->campus->id),
                'short' => $Residence->campus->short,
            ],
        ];

        if (isset($Residence->pivot)) {
            $data['pivot'] = [
                'room' => $Residence->pivot->room,
                'from' => $Residence->pivot->from,
                'to' => $Residence->pivot->to,
            ];
        }

        return $data;
    }
}
