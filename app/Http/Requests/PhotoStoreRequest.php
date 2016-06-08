<?php

namespace App\Http\Requests;

class PhotoStoreRequest extends Request
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
            'user_id' => 'alpha_num|exists:users,id',
            'title'   => 'required|string|min:3',
            'type'    => 'required|in:profile,biaude',
            'photo'   => 'string',
        ];
    }
}
