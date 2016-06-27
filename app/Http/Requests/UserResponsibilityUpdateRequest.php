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
        $rules = (new ResponsibilityStoreRequest())->rules();

        unset($rules['user_id']);

        foreach ($rules as &$rule) {
            $rule = str_replace('required|', '', $rule);
        }
        
        return $rules;
    }
}
