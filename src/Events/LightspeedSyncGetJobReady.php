<?php

namespace Rvzug\LightspeedSync\Events;

use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGetJobReady {

    public function __construct($resource, $id, $response, $params = [], $childresources = false)
    {
        if($childresources && is_array($childresources))
        {
            foreach($childresources as $oneChildResource)
                LightspeedSyncFacade::get($oneChildResource, $id, $params);
        }
    }
}