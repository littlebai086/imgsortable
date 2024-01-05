<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataEditorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->id){
            $method = "update";
        }else{
            $method = "create";
        }
        $validationRules = array();
        switch ($method){
            case "create":
                $validationRules["title"] = [
                    'required',
                    Rule::unique(config('project.data_editor'))
                ];
                break;
            case "update":
                $validationRules["title"] = [
                    'required',
                    Rule::unique(config('project.data_editor'))->ignore(request()->id, 'id')
                ];
                break;
        }
        $validationRules["content"] = ['required'];
        return $validationRules;
    }
    public function messages()
    {
        $message = [
            'title.required' => '請填寫標題。',
            'title.unique' => '標題不可重覆。',
            'content.required' => '請填寫介紹。',
        ];
        return $message;
    }
}
