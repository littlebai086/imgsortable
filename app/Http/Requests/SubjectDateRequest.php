<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubjectDateRequest extends FormRequest
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
                $validationRules["date"] = [
                    'required',
                    Rule::unique(config('project.subject_date'))
                ];
                // $validationRules['multiple_img.*'] = ['image','mimes:jpeg,png,jpg,gif'];
                break;
            case "update":
                $validationRules["date"] = [
                    'required',
                    Rule::unique(config('project.subject_date'))->ignore(request()->id, 'id')
                ];
                break;
        }
        $validationRules['subject'] = ['required'];
        $validationRules['intro'] = ['required'];
        $validationRules['multiple_img.*'] = ['image','mimes:jpeg,png,jpg,gif'];
        $validationRules['start_date'] = ['required','after:date'];
        return $validationRules;
    }

    public function messages()
    {
        $message = [
            'date.required' => '請填寫資料日期。',
            'date.unique' => '資料日期不可重覆。',
            'subject.required' => '請填寫主題。',
            'intro.required' => '請填寫介紹。',
            'start_date.required' => '上架日期不可為空。',
            'start_date.after' => '上架日期不可早於資料日期。',
            'multiple_img.image' => '請選擇圖片上傳',
            'multiple_img.mimes' => '上傳檔案應為這些',
        ];
        return $message;
    }
}
