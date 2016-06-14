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
    public function transform(Residence $residence)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('residences.show', $residence->id),
            'name' => $residence->name,
            'address' => $residence->address,
            'lat' => $residence->lat,
            'lng' => $residence->lng,
            'campus' => [
                'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $residence->campus->id),
                'short' => $residence->campus->short,
            ],
        ];

        if (isset($residence->pivot)) {
            $pivot = [
                'room' => $residence->pivot->room,
                'from' => $residence->pivot->from,
                'to' => $residence->pivot->to,
            ];

            $data['self'] = app('Dingo\Api\Routing\UrlGenerator')
                ->version('v1')
                ->route('users.residences.show', [$residence->pivot->user_id, $residence->pivot->id]);

            $data = array_merge($data, $pivot);
        }

        return $data;
    }
}
