<?php

namespace Siravel\Models\Commerce;

use Siravel\Models\SiravelModel;
use Siravel\Models\Commerce\Order;
use Siravel\Models\Commerce\Refund;

use Siravel\Models\Traits\BusinessTrait;

class Transaction extends SiravelModel
{
    use BusinessTrait;
    
    public $table = 'transactions';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'provider',
        'state',
        'subtotal',
        'coupon',
        'tax',
        'total',
        'shipping',
        'refund_date',
        'refund_requested',
        'provider_id',
        'provider_date',
        'provider_dispute',
        'user_id',
        'notes',
        'cart',
        'response',
    ];

    public $rules = [];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function getStateAttribute($value)
    {
        return ucfirst($value);
    }

    public function getAmountAttribute()
    {
        return $this->total;
    }

    public function getTotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getTaxAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getShippingAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getSubtotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
