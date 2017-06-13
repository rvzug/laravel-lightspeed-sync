<?php

namespace Rvzug\LightspeedSync\Traits;

trait HasResourceAttributes {

    public function resourceAttributeExists($attribute)
    {
        return (in_array($attribute, $this->resources))? true: false;
    }

    public function processGuardedAttribute($guardedAttribute, $data)
    {
        if(is_array($data) && (count($data) === 1) && isset($data["resource"]["id"])) {
            $this->setAttribute($guardedAttribute, $data["resource"]["id"]);
        }
        else{
            $this->setAttribute($guardedAttribute, 0);
        }
    }

}
