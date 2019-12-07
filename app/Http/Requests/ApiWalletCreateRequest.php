<?php

namespace App\Http\Requests;

use App\Enum\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiWalletCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency' => 'required', Rule::in(Currency::values()),
            'user_id' => 'required'
        ];
    }
}
