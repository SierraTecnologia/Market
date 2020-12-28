<?php

namespace Market\Http\Requests;

use Market\Models\Coupon;

class CouponRequest extends CommerceRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Coupon::class)->rules;
    }
}
