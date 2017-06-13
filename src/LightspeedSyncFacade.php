<?php

namespace Rvzug\LightspeedSync;

use Illuminate\Support\Facades\Facade;

class LightspeedSyncFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'lightspeedsync';
    }
}