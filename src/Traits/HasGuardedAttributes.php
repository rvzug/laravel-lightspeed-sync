<?php

namespace Rvzug\LightspeedSync\Traits;

use Illuminate\Database\Eloquent\MassAssignmentException;

trait HasGuardedAttributes {

    use HasGuardedAttributes;

    public function fill(array $attributes)
    {
        // snippet from https://github.com/laravel/framework/blob/5.3/src/Illuminate/Database/Eloquent/Model.php#L431 to overwrite the base fill() method.
        $totallyGuarded = $this->totallyGuarded();
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            $key = $this->removeTableFromKey($key);
            // The developers may choose to place some attributes in the "fillable"
            // array, which means only those attributes may be set through mass
            // assignment to the model, and all others will just be ignored.
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException($key);
            }
        }

        $this->processGuardedAttributes($attributes);
        return $this;
    }

    public function hasGuardedAttributes()
    {
        return (!isset($this->guarded) || empty($this->guarded))? true: false;
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
            throw new \Exception("The parameter $data requires to be an array with (possible) multiple attributes");

        if(!$this->hasGuardedAttributes())
            return $this;

        foreach ($this->getGuardedAttributes() as $guardedAttribute)
        {


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
            return $this->{'process'.ucfirst($guardedAttribute)}($data[$guardedAttribute]);
        }
        elseif(in_array(get_class(HasResourceAttributes::class), class_uses($this))) {
            if ($this->resourceAttributeExist($guardedAttribute))
                return $this->processResourceAttribute($guardedAttribute, $data);
        }
        elseif(method_exists($this, $guardedAttribute))
        {
            // if there aren't any process functions for this, it could be an relation
            return true;
        }

        // well, if there are no other possible resolvings, just pass the data to the attribute.
        $this->setAttribute($guardedAttribute, $data);
        return true;
    }

}