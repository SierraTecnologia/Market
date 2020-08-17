<?php

namespace Market\Http\Requests;

use Market\Models\Commerce\Transaction;

class TransactionsRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Transaction::$rules;
    }
}
