<?php

namespace App\Http\Requests;

class PhotoUpdateRequest extends Request
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
        $rules = (new PhotoStoreRequest())->rules();

        unset($rules['user_id']);
        unset($rules['photo']);

        foreach ($rules as &$rule) {
            $rule = str_replace('required|', '', $rule);
        }
        
        return $rules;
    }
}
