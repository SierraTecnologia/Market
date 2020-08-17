<?php

namespace Siravel\Models\Commerce;

use Siravel\Models\SiravelModel;
use Siravel\Models\Commerce\OrderItem;

use Siravel\Models\Traits\BusinessTrait;

class Refund extends SiravelModel
{
    use BusinessTrait;
    
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
