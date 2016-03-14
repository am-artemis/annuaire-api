<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Gadz;

class GadzTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Gadz $gadz)
    {
        $data = [
            'buque' => $gadz->buque,
            'fams' => $gadz->fams,
            'famsSearch' => $gadz->famsSearch,
            'proms' => (int) $gadz->proms,
        ];

        return $data;
    }
}
