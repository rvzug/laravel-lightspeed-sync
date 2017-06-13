<?php

namespace Rvzug\LightspeedSync\Events;

use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncGetPageJobReady {


    public function __construct($resource, $response, $params = [], $childresources = false)
    {
        if($childresources && is_array($childresources)) {

            if (is_array($response) || count($response) > 0) {

                foreach ($response as $item)
                {
                    $id = $item['id'];
                    foreach($childresources as $oneChildResource)
                        LightspeedSyncFacade::get($oneChildResource, $id, $params);
                }
            }
        }
    }
}