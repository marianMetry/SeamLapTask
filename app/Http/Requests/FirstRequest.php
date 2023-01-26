<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'start_num'=>'required|numeric|min:1',
                'end_num'=>'required|numeric|gt:start_num',

        ];
    }
}
