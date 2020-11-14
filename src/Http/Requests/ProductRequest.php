<?php

namespace Market\Http\Requests;

use Market\Models\Product;

class ProductRequest extends CommerceRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Product::class)->rules;
    }
}
