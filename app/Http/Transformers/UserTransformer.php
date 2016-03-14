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
            'self' => url(implode('/', ['api', 'users', $user->id])),
            'contact' => [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'birthday' => $user->birthday->format('Y-m-d'),
                'gender' => $user->gender,
                'mail' => $user->mail,
                'phone' => $user->phone,
            ],
            'promo' => [
                'campus' => $this->itemArray($user->campus, new CampusTransformer),
                'year' => (int) $user->year,
            ],
            'gadz' => null,
        ];

        if ($gadz = $user->gadz) {
            $data['gadz'] = $this->itemArray($gadz, new GadzTransformer);
            $data['gadz']['promsTBK'] = $user->campus->prefix . $gadz->proms;
        }

        return $data;
    }
}
