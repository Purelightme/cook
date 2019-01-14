<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch (\request()->getPathInfo()){
            case '/user/cooks':
                if (\request()->isMethod('POST')){
                    $rules['title'] = 'required';
                    $rules['category_ids'] = 'required';
                    $rules['introduction'] = 'required';
                    $rules['ingredients'] = 'required';
                }
                break;
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \request()->user('api');
    }
}
