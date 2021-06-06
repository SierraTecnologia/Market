<?php

namespace Market\Http\Requests;

use Market\Models\Transaction;

class TransactionsRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Transaction::class)->rules;
    }
}
