<?php

namespace Market\Models;

use Market\Models\MarketModel;
use Market\Models\Product;

use Market\Models\Traits\BusinessTrait;

class Favorite extends MarketModel
{
    use BusinessTrait;
    
    public $table = 'favorites';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'user_id',
    ];

    /**
     * Get the corresponding Product
     *
     * @return Relationship
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
