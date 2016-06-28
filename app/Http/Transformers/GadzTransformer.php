<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Gadz;

class GadzTransformer extends BaseTransformer
{
    public function transform(Gadz $gadz)
    {
        $data = [
            'buque'      => $gadz->buque,
            'fams'       => $gadz->fams,
            'famsSearch' => $gadz->famsSearch,
            'proms'      => (int)$gadz->proms,
        ];

        return $data;
    }
}
