<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return[
            'content'=>'required|min:3'

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
