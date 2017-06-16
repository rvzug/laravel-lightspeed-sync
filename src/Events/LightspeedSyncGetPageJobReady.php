<?php

namespace Rvzug\LightspeedSync\Events;

use Rvzug\LightspeedSync\LightspeedSync;
use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGetPageJobReady {

    public function __construct($resource, $response, $params = [], $childresources = false)
    {
        foreach ($response as $item) {
            $itemId = $item['id'];
            LightspeedSyncFacade::in($resource, $itemId, $item);
        }

        if($childresources && is_array($childresources)) {

            if (is_array($response) || count($response) > 0) {

                foreach ($response as $item)
                {
                    $childresourceId = $item['id'];
                    foreach($childresources as $oneChildResource)
                        LightspeedSyncFacade::get($oneChildResource, $childresourceId, []);
                }
            }
        }
    }
}