<?php

namespace Market\Http\Requests;

use Market\Models\Plan;

class PlanRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Plan::class)->rules;
    }
}
