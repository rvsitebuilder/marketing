<?php

namespace Rvsitebuilder\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SsoRequest extends FormRequest
{
    public function rules(): array
    {
        //TODO Update validation rules
        return [
            'sso1' => 'required|max:1',
            'sso2' => 'required|max:1',
        ];
    }

    public function authorize(): bool
    {
        //role admin only
        return (Auth::admin()) ? true : false;
    }

    /**
     * Define custom error message.
     */
    public function messages(): array
    {
        //TODO language system
        return [
            'sso1.required' => __('rvsitebuilder/marketing::validation.Sso.sso1.required'),
            'sso1.max' => __('rvsitebuilder/marketing::validation.Sso.sso1.max'),
            'sso2.required' => __('rvsitebuilder/marketing::validation.Sso.sso2.required'),
            'sso2.max' => __('rvsitebuilder/marketing::validation.Sso.sso2.max'),
        ];
    }
}
