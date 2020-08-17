<?php

namespace Market\Models;

use Market\Models\MarketModel;
use Market\Models\OrderItem;


class Refund extends MarketModel
{
    
    public $table = 'refunds';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'transaction_id',
        'provider_id',
        'provider',
        'uuid',
        'amount',
        'charge',
        'currency',
    ];

    public $rules = [];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }

    public function getAmountAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
