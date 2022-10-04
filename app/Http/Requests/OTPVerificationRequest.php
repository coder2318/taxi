<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OTPVerificationRequest extends FormRequest
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
            'country_code' => 'required',
            'mobile_number' => 'required',
            'code' => 'required',
            'type' => 'required',
        ];
    }
}
