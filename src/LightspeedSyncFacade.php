<?php

namespace Rvzug\LightspeedSync;

use Rvzug\LightspeedSync\Jobs\LightspeedSyncCount;
use Rvzug\LightspeedSync\Jobs\LightspeedSyncGet;
use Rvzug\LightspeedSync\Jobs\LightspeedSyncGetPage;

class LightspeedSyncFacade {

    public static function count($resource, $params = [])
    {
        // well, don't know any logical needs for this but...
        dispatch(new LightspeedSyncCount($resource, $params, false));
    }

    public static function get($resource, $id = null, $params = [])
    {
        if($id == null)
            self::getAll($resource, $params, true);

        dispatch(new LightspeedSyncGet($resource, $id, $params));
    }

    public static function getAll($resource, $params = [])
    {
        dispatch(new LightspeedSyncCount($resource, $params, true, false));
    }

    public static function getAllWithChildResources($resource, $childresources, $params = [])
    {

        dispatch(new LightspeedSyncCount($resource, $params, true, $childresources));
    }

    public static function getPage($resource, $page = 1, $param = [], $childresources = false)
    {
        dispatch(new LightspeedSyncGetPage($resource, $page, $param, $childresources));
    }


    public static function in($resource, $data)
    {
        LightspeedSync::in($resource, $data);
    }

    private function getChildresources($resource)
    {
        LightspeedSync::getChildresources($resource);
    }
}