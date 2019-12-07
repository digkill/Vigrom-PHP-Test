<?php

namespace App\Http\Requests;

use App\Enum\Cause;
use App\Enum\Currency;
use App\Enum\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiWalletChangeBalanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wallet_id'        => 'required',
            'transaction_type' => ['required', Rule::in(TransactionType::values())],
            'amount'           => ['required'],
            'currency' => 'required', Rule::in(Currency::values()),
            'cause' => 'required', Rule::in(Cause::values()),
        ];
    }
}
