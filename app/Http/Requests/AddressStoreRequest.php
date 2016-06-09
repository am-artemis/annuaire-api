<?php

namespace App\Http\Requests;

class AddressStoreRequest extends Request
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
            'user_id' => 'required|alpha_num|exists:users,id',
            'name'    => 'required|string|min:3',
            'address' => 'required|string|min:3',
            'zipcode' => 'required|numeric',
            'city'    => 'required|min:1',
            'country' => '',
            'lat'     => 'numeric',
            'lng'     => 'numeric',
            'phone'   => 'regex:/^[-+ .0-9]+$/',
            'from'    => 'required|date',
            'to'      => 'date',
            'type'    => 'required|in:perso,family',
        ];
    }
}
