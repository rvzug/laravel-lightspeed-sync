<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedProductsImage extends Model
{
    protected $table = 'lightspeed_productimages';
    public $incrementing = false;
    protected $fillable = ['id', 'product', 'sortOrder', 'createdAt', 'updatedAt', 'extention', 'size', 'title', 'thumb', 'src'];

    public function product()
    {
        return $this->belongsTo('App\LightspeedProduct', 'product');
    }

}
