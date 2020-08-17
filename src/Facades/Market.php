<?php

namespace Market\Facades;

use Illuminate\Support\Facades\Facade;

class Market extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'market';
    }
}
