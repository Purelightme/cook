<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CookCollectRequest extends FormRequest
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
            case '/user/cook-collects':
                if (in_array(\request()->method(),['POST','DELETE'])){
                    $rules['cook_id'] = 'required|exists:cooks,id';
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
