<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SynonymRequest extends FormRequest
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
        $rules = [
            'type' => [
                'required',
                Rule::in('chinese', 'vietnamese'),
            ],
        ];

        if ($this->isMethod(self::METHOD_POST)) {
            $rules['wordId']  = 'required';
            $rules['synonymId']  = 'required';
        }

        if ($this->isMethod(self::METHOD_DELETE)) {
            $rules['synonymId']  = 'required';
        }

        return $rules;
    }
}
