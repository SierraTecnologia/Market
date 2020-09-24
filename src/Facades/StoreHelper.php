<?php

namespace Market\Facades;

use Illuminate\Support\Facades\Facade;

class StoreHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'storeHelper';
    }
}
