<?php

namespace Siravel\Models\Commerce;

use Siravel\Models\SiravelModel;

use Siravel\Models\Traits\BusinessTrait;

class Plan extends SiravelModel
{
    use BusinessTrait;
    
    public $table = 'plans';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'name',
        'title',
        'uuid',
        'amount',
        'interval',
        'currency',
        'enabled',
        'sitecpayment_name',
        'trial_days',
        'subscription_name',
        'descriptor',
        'description',
        'is_featured',
    ];

    public $rules = [
        'name' => 'required',
        'amount' => 'required',
        'interval' => 'required',
        'currency' => 'required',
        'descriptor' => 'required',
        'description' => 'required',
    ];

    public function getPlansBySierraTecnologiaId($name)
    {
        return $this->where('sitecpayment_name', $name)->first();
    }

    public function getFrequencyAttribute()
    {
        switch ($this->interval) {
            case 'week':
                return 'weekly';
            case 'month':
                return 'monthly';
            case 'year':
                return 'yearly';
            default:
                return $this->interval;
        }
    }

    public function getAmountAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getHrefAttribute()
    {
        return route('siravel.commerce.plan', [$this->uuid]);
    }

    public function subscribeBtn($content = '', $class = '')
    {
        return '<form method="post" action="'.route('siravel.commerce.subscribe', [crypto_encrypt($this->id)]).'">'.csrf_field().'<button class="'.$class.'">'.$content.'</button></form>';
    }
}
