<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Campus;

class CampusTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Campus $campus
     * @return array
     */
    public function transform(Campus $campus)
    {
        // Choix de la préposition
        switch (strtolower($campus->name[0])) {
            case 't':
            case 'j':
            case 'c':
                $prep = '["du","au"]';
                break;
            
            case 'b':
            case 'k':
                $prep = '["de la","à la"]';
                break;
            
            default:
                $prep = '["de l\'", "à l\'"]';
                break;
        }

        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('campuses.show', $campus->id),
            'id' => (int) $campus->id,
            'name' => $campus->name,
            'city' => $campus->city,
            'short' => $campus->short,
            'prep' => $prep,
            'prefix' => $campus->prefix,
            'address' => $campus->address,
            'pos' => [
                'lat' => (double) $campus->lat,
                'lng' => (double) $campus->lng,
            ],
            'photo' => url($campus->photo),
        ];

        return $data;
    }
}
