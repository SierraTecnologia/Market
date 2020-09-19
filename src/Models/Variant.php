<?php

namespace Market\Models;

use Market\Models\MarketModel;
use Market\Services\ProductService;


class Variant extends MarketModel
{
    
    public $table = 'product_variants';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'key',
        'value',
    ];

    public $rules = [];

    public function getOptionsAttribute()
    {
        return app(ProductService::class)->variantOptions($this);
    }

    public function rawValue($value)
    {
        $valueWithoutParenthesis = preg_replace("/\([^)]+\)/", "", $value);
        $valueWithoutSquareParenthesis = preg_replace("/\[[^)]+\]/", "", $valueWithoutParenthesis);

        return ucfirst($valueWithoutSquareParenthesis);
    }
}
