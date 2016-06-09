<?php

namespace App\Http\Requests;

class UserAddressUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'string|min:3',
            'address' => 'string|min:3',
            'zipcode' => 'numeric',
            'city'    => 'min:1',
            'country' => '',
            'lat'     => 'numeric',
            'lng'     => 'numeric',
            'phone'   => 'regex:/^[-+ .0-9]+$/',
            'from'    => 'date',
            'to'      => 'date',
            'type'    => 'in:perso,family',
        ];
    }
}
