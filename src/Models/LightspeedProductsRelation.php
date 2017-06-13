<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedProductsRelation extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_productrelations';
    public $incrementing = false;
    protected $fillable = ['id', 'product', 'sortOrder'];
    protected $guarded = ['relatedProduct'];
    protected $resources = ['relatedProduct'];

    public function __construct(LightspeedProduct $product)
    {
        $this->product = $product;
    }

    public function product()
    {
        return $this->belongsTo('App\LightspeedProduct', 'product');
    }

    public function relatedProduct()
    {
        return $this->hasOne('App\LightspeedProduct', 'relatedProduct');
    }

}
