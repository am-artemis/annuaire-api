<?php

namespace App\Http\Requests;

class CourseUpdateRequest extends Request
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
        $rules = (new CourseStoreRequest())->rules();

        unset($rules['campus_id']);
        
        return $rules;
    }
}
