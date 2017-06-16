<?php

namespace Rvzug\LightspeedSync\Events;

use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGetJobReady {

    public function __construct($resource, $parentResourceId, $response, $params = [], $childresources = false)
    {
        foreach ($response as $item)
        {
            $itemId = $item["id"];
            LightspeedSyncFacade::in($resource, $itemId, $item, $parentResourceId);

            if($childresources && is_array($childresources))
            {
                foreach($childresources as $oneChildResource)
                    LightspeedSyncFacade::get($oneChildResource, $itemId, $params);
            }
        }

    }
}