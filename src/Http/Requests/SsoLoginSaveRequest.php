<?php

namespace Rvsitebuilder\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SsoLoginSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'loginType' => 'required',
            'loginURL' => 'required',
            'logoutURL' => 'required',
            'ipLength' => 'required',
            'secretKey' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function messages(): array
    {
        //TODO language system
        return [
            'loginType.required' => __('rvsitebuilder/marketing::validation.SsoLoginSave.loginType'),
            'loginURL.required' => __('rvsitebuilder/marketing::validation.SsoLoginSave.loginURL'),
            'logoutURL.required' => __('rvsitebuilder/marketing::validation.SsoLoginSave.logoutURL'),
            'ipLength.required' => __('rvsitebuilder/marketing::validation.SsoLoginSave.ipLength'),
            'secretKey.required' => __('rvsitebuilder/marketing::validation.SsoLoginSave.secretKey'),
        ];
    }
}
