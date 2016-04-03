<?php

namespace App\Http\Transformers;

// use Illuminate\Http\Request;
use Dingo\Api\Http\Request;

use App\User;

class UserTransformer extends BaseTransformer
{
    /**
     * List of fields available.
     *
     * @var array
     */
    protected $fields = ['id', 'self', 'contact', 'promo', 'gadz', 'photos'];

    /**
     * List of minimal set of fields to filter before sending the response if null, all fields will be sent.
     *
     * @var array
     */
    protected $fields_minimal = ['id', 'self', 'contact', 'promo', 'gadz'];

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

        $data = $this->filter($data);

        return $data;
    }
}
