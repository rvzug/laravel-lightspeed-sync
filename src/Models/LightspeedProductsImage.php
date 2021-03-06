<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedProductsImage extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_productimages';
    public $incrementing = false;
    protected $fillable = ['id', 'sortOrder', 'createdAt', 'updatedAt', 'extention', 'size', 'title', 'thumb', 'src'];
    protected $guarded = ['product'];
    protected $parentResourceAttribute = 'product';

    public function product()
    {
        return $this->belongsTo('App\LightspeedProduct', 'product');
    }

}
