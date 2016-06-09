<?php

namespace App\Http\Requests;

class UserResponsibilityUpdateRequest extends Request
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
            'title'  => 'string|min:3',
            'strass' => 'string|min:3',
            'from'   => 'date',
            'to'     => 'date',
        ];
    }
}
