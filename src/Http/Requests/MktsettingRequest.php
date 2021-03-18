<?php

namespace Rvsitebuilder\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MktsettingRequest extends FormRequest
{
    public function rules(): array
    {
        //TODO Update validation rules
        return [
                //TODO to pam can't use required in request because ajax use request onkeyup and save follwing send data , need not to have id and secret at the same time
                //'GA_API_CLIENT_ID' => 'required',
                //'GA_API_CLIENT_SECRET' => 'required',
        ];
    }

    public function authorize()
    {
        //role admin only
        return $this->user()->isAdmin();
    }

    /**
     * Define custom error message.
     */
    public function messages(): array
    {
        //TODO language system
        return [
                //'GA_API_CLIENT_ID.required' => 'The "GA_API_CLIENT_ID" field is required.',
                //'GA_API_CLIENT_SECRET.required' => 'The "GA_API_CLIENT_SECRET" field is required.',
        ];
    }
}
