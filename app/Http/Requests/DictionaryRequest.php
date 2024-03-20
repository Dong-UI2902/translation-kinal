<?php

namespace App\Http\Requests;

use App\Models\Chinese;
use App\Models\Vietnamese;
use App\Rules\ChineseHasTag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DictionaryRequest extends FormRequest
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
            'chinese.text' => 'required',
            'chinese.type' => [
                'required',
                Rule::in([Chinese::TYPE_SIMPLIFIED, Chinese::TYPE_TRADITIONAL]),
            ],

            'vietnamese.text' => 'required',
            'vietnamese.type' => [
                'required',
                Rule::in([Vietnamese::TYPE_NORMAL, Vietnamese::TYPE_CHINESE_VIETNAMESE]),
            ],

            'posTag' => [
                'required',
                'exists:word_pos_tags,code',
            ],
        ];
    }
}
