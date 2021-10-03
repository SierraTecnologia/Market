<?php

namespace Market\Models;

use Market\Models\MarketModel;
use Market\Models\Product;


class Favorite extends MarketModel
{
    
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class);
    }
}
