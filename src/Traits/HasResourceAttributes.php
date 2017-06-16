<?php

namespace Rvzug\LightspeedSync\Traits;

trait HasResourceAttributes {

    use HasGuardedAttributes;

    public function hasResourceAttributes(){
        return (isset($this->resources) && is_array($this->resources) && count($this->resources) > 0)? true: false;
    }

    public function resourceAttributeExists($attribute)
    {
        if($this->hasResourceAttributes())
            return (in_array($attribute, $this->resources))? true: false;
        else return false;
    }

    public function processResourceAttribute($guardedAttribute, $data)
    {
        if(is_array($data) && (count($data) === 1) && isset($data["resource"]["id"])) {
            $this->setAttribute($guardedAttribute, $data["resource"]["id"]);
        }
        else{
            $this->setAttribute($guardedAttribute, 0);
        }
    }

}
