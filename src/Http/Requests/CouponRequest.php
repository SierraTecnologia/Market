<?php

namespace Market\Http\Requests\Commerce;

use Market\Models\Commerce\Coupon;

class CouponRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Coupon::$rules;
    }
}
