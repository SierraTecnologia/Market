<?php

namespace Market\Models;

use Market\Models\MarketModel;

use Market\Models\Traits\BusinessTrait;

class Cart extends MarketModel
{
    use BusinessTrait;
    
    public $table = 'cart';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'address',
        'product_variants',
        'quantity',
    ];

    public $rules = [];
}
