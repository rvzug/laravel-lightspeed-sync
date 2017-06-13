<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedProductAttribute extends Model
{

    protected $table = 'lightspeed_productattributes';
    public $incrementing = true; // Lightspeed does not return a ProductAttibuteId but the attribute id. We change that to a incrementing id.
    protected $fillable = ['product', 'value', 'attribute'];

    public function product()
    {
        return $this->belongsTo('App\LightspeedProduct', 'product');
    }

    public function attribute()
    {
        return $this->hasOne('App\LightspeedAttribute', 'attribute');
    }


}