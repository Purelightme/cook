<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [];
        switch (\request()->getPathInfo()){
            case '/user/suggests':
                if (\request()->isMethod('POST')){
                    $rule['content'] = 'required|max:200';
                }
                break;
        }
        return $rule;
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
