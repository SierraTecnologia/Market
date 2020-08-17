<?php

namespace Siravel\Models\Commerce;

use Siravel\Models\SiravelModel;
use Siravel\Services\Commerce\ProductService;

use Siravel\Models\Traits\BusinessTrait;

class Variant extends SiravelModel
{
    use BusinessTrait;
    
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
        $valueWithoutParenthesis = preg_replace("/\([^)]+\)/","", $value);
        $valueWithoutSquareParenthesis = preg_replace("/\[[^)]+\]/","", $valueWithoutParenthesis);

        return ucfirst($valueWithoutSquareParenthesis);
    }
}
