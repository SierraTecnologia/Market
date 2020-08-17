<?php

namespace Market\Models;

use Market\Models\MarketModel;


class Cart extends MarketModel
{
    
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
