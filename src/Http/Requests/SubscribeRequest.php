<?php

namespace Armincms\MDarman\Http\Requests;

class SubscribeRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
        ];
    }
}
