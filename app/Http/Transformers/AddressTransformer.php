<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Address;

class AddressTransformer extends BaseTransformer
{
    public function transform(Address $address)
    {
        return [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')
                ->route('users.addresses.show', [$address->user->id, $address->id]),
            'name' => $address->name,
            'address' => $address->address,
            'zipcode' => (int)$address->zipcode,
            'city'    => $address->city,
            'country' => $address->country,
            'pos'     => [
                'lat' => (string)$address->lat,
                'lng' => (string)$address->lng,
            ],
            'phone' => $address->phone,
            'from' => is_null($address->from) ? null : $address->from->format('Y-m-d'),
            'to' => is_null($address->to) ? null : $address->to->format('Y-m-d'),
            'type' => $address->type,
        ];
    }
}
