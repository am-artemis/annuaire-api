<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Photo;

class PhotoTransformer extends BaseTransformer
{
    public function transform(Photo $photo)
    {
        $data = [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('photos.show', $photo->id),
            'src' => $photo->src,
            'type' => $photo->type,
            'title' => $photo->title,
            'user' => [
                'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.show', $photo->user_id),
            ],
        ];

        return $data;
    }
}
