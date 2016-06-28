<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Social;

class SocialTransformer extends BaseTransformer
{
    public function transform(Social $social)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('socials.show', $social->id),
            'name' => $social->name,
            'logo' => $social->logo,
        ];

        if (isset($social->pivot)) {
            $data['url'] = $social->pivot->url;
        }
        
        return $data;
    }
}
