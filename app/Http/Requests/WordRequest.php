<?php

namespace App\Http\Requests;

use App\Models\Chinese;
use App\Models\Vietnamese;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WordRequest extends FormRequest
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
        $wordType = \Str::before($this->route()->getName(), '.');
        $id = $this->route($wordType);
        $typeRule = Rule::in([Vietnamese::TYPE_NORMAL, Vietnamese::TYPE_CHINESE_VIETNAMESE]);

        if ($wordType == "chinese") {
            $typeRule = Rule::in([Chinese::TYPE_SIMPLIFIED, Chinese::TYPE_TRADITIONAL]);
        }

        $rules = [
            'type' => [
                'required',
                $typeRule,
            ],
            'text' => [
                'required',
                Rule::unique($wordType)->where(function ($query) {
                    return $query->where($this->only('type', 'text'));
                })->ignore($id),
            ],
        ];

        if ($this->isMethod(self::METHOD_POST)) {
            $rules['posTag'] = [
                'required',
                'exists:word_pos_tags,code',
            ];
        }

        return $rules;
    }

}
