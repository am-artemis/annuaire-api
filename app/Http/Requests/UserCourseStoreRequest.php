<?php

namespace App\Http\Requests;

class UserCourseStoreRequest extends Request
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
            'id'   => 'alpha_num|exists:courses,id',
            'room' => 'required|string|min:2',
            'from' => 'required|date',
            'to'   => 'required|date',
        ];
    }
}
