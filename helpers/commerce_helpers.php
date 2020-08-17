<?php

if (!function_exists('commerce')) {
    function commerce()
    {
        return app(Market\Services\StoreHelperService::class);
    }
}
