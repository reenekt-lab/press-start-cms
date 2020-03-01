<?php

namespace App\Http\Requests\System\Security\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login'=>'required',
            'email'=>'email',
        ];
    }
}
