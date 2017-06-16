<?php

namespace Rvzug\LightspeedSync\Traits;

trait HasGuardedAttributes {

    public function hasGuardedAttributes()
    {
        return (isset($this->guarded) && is_array($this->guarded) && count($this->guarded) > 0)? true: false;
    }
    public function guardedAttributeExists($attribute)
    {
        return (in_array($attribute, $this->guarded))? true: false;
    }

    private function getGuardedAttributes()
    {
        if(!$this->hasGuardedAttributes())
            return false;

        return $this->guarded;
    }

    /**
     * Set multiple guarded attributes.
     * @param $data array filled with attribute value pairs. Value may contain an array.
     * @throws \Exception "The parameter $data requires to be an array with (possible) multiple attributes"
     * @return object Model
     */
    public function processGuardedAttributes($data)
    {
        if(!is_array($data))
            throw new \Exception("The parameter \$data requires to be an array with (possible) multiple attributes");

        if(!$this->hasGuardedAttributes())
            return $this;

        foreach ($this->getGuardedAttributes() as $guardedAttribute)
        {
            $this->processGuardedAttribute($guardedAttribute, $data[$guardedAttribute]);
        }
        return $this;
    }

    /**
     * Set one guarded attribute.
     * @param $guardedAttribute string
     * @param $data mixed
     * @return boolean
     */
    public function processGuardedAttribute($guardedAttribute, $data)
    {
        if(!$this->guardedAttributeExists($guardedAttribute))
            return false;

        if(method_exists($this, 'process'.ucfirst($guardedAttribute))){

            // this attribute is an attribute with additional function. Let the method fix it.
            return $this->{'process'.ucfirst($guardedAttribute)}($data);
        }

        if(isset($this->parentResourceAttribute) && $this->parentResourceAttribute == $guardedAttribute)
        {
            $this->setAttribute($guardedAttribute, $data);
            return true;
        }

        if(in_array(HasResourceAttributes::class, class_uses($this))) {
            if ($this->resourceAttributeExists($guardedAttribute))
                return $this->processResourceAttribute($guardedAttribute, $data);
        }

        if(method_exists($this, $guardedAttribute))
        {
            // if there aren't any process functions for this, it could be an relation
            return true;
        }

        // well, if there are no other possible revolvings, just pass the data to the attribute.
        $this->setAttribute($guardedAttribute, $data);

        return true;
    }

}