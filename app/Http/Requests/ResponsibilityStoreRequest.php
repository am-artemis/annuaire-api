<?php

namespace App\Http\Requests;

class ResponsibilityStoreRequest extends Request
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
            'campus_id' => 'required|integer|exists:campuses,id',
            'title'     => 'required|string|min:3',
            'strass'    => 'required|string|min:3',
            'from'      => 'required|date',
            'to'        => 'required|date',
        ];
    }
}
