<?php

namespace Market\Http\Requests\Commerce;

use Market\Models\Commerce\Plan;

class PlanRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Plan::$rules;
    }
}
