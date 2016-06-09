<?php

namespace App\Http\Transformers;

use Illuminate\Http\Request;

use App\Models\Address;

class AddressTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array
     *
     * @param Address $address
     * @return array
     */
    public function transform(Address $address)
    {
        return [
            'self' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')
                ->route('users.addresses.show', [$address->user->id, $address->id]),
            'name' => $address->name,
            'address' => $address->address,
            'zipcode' => (int) $address->zipcode,
            'city' => $address->city,
            'country' => $address->country,
            'lat' => (double) $address->lat,
            'lng' => (double) $address->lng,
            'phone' => $address->phone,
            'from' => is_null($address->from) ? null : $address->from->format('Y-m-d'),
            'to' => is_null($address->to) ? null : $address->to->format('Y-m-d'),
            'type' => $address->type,
        ];
    }
}
