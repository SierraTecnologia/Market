<?php

namespace Siravel\Models\Commerce;

use Siravel\Models\SiravelModel;

use Siravel\Models\Traits\BusinessTrait;

class Cart extends SiravelModel
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
