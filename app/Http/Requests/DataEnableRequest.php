<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataEnableRequest extends FormRequest
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
                    Rule::unique(config('project.data_enable'))
                ];
                break;
            case "update":
                $validationRules["title"] = [
                    'required',
                    Rule::unique(config('project.data_enable'))->ignore(request()->id, 'id')
                ];
                break;
        }
        return $validationRules;
    }
    public function messages()
    {
        $message = [
            'title.required' => '請填寫標題。',
            'title.unique' => '標題不可重覆。',
        ];
        return $message;
    }
}
