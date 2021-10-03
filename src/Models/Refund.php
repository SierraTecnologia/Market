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

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function orderItem(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderItem::class);
    }

    public function getAmountAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
