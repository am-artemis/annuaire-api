<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\User;

class UserTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        $data = [
            'id' => $user->id,
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.show', $user->id),
            'contact' => [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'birthday' => $user->birthday->format('Y-m-d'),
                'gender' => $user->gender,
                'mail' => $user->mail,
                'phone' => $user->phone,
                'photo' => $user->profilePicSrc(),
            ],
            'promo' => [
                'campus' => $this->itemArray($user->campus, new CampusTransformer),
                'year' => (int) $user->year,
            ],
            'gadz' => null,
            'photos' => null,
        ];

        if ($gadz = $user->gadz) {
            $data['gadz'] = $this->itemArray($gadz, new GadzTransformer);
            $data['gadz']['promsTBK'] = $user->campus->prefix . $gadz->proms;
        }

        if ($photos = $user->photos) {
            // $data['contact']['photo'] = $user->profilePicSrc();
            $data['photos'] = $this->collectionArray($photos, new PhotoTransformer);
        }

        // TODO: Filtrer la réponse pour enlever les champs inutiles (parametre fields)
        return $data;
    }
}
