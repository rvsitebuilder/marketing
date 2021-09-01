<?php

namespace Rvsitebuilder\Marketing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MktRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * See more: https://laravel.com/docs/5.5/validation#available-validation-rules
     */
    public function rules(): array
    {
        //TODO Update validation rules
        return [
            '1' => 'required',
            '2' => 'required',
        ];
    }

    /**
     * Define custom error message.
     */
    public function messages(): array
    {
        //TODO language system
        return [
            '1.required' => __('rvsitebuilder/marketing::validation.Mkt.Mkt1'),
            '2.required' => __('rvsitebuilder/marketing::validation.Mkt.Mkt2'),
        ];
    }
}
