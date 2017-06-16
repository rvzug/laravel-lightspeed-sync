<?php

namespace Rvzug\LightspeedSync\Events;

use Rvzug\LightspeedSync\LightspeedSyncFacade;

class LightspeedSyncCountJobReady {

    public function __construct($resource, $response, $params = [], $get = false, $childresources = false)
    {
        if($childresources)
            $get = true;

        if($get) {
            if(!in_array('limit', $params) || !is_int($params['limit']) || $params['limit'] == 0)
                $params['limit'] = 250;

            $pages = ceil($response / $params['limit']);

            for($i=1; $i<=$pages; $i++){
                LightspeedSyncFacade::getPage($resource, $i, $params, $childresources);
            }
        }
    }
}