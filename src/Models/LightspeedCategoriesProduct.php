<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedCategoriesProduct extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_categoriesproducts';
    public $incrementing = false;
    protected $fillable = ['id', 'sortOrder'];
    protected $guarded = ['category', 'product'];
    protected $resources = ['category', 'product'];

    protected $casts = [
    ];

    public function category(){
        return $this->hasMany('App\LightspeedCategory', 'id', 'category');
    }

    public function attribute(){
        return $this->hasMany('App\LightspeedProduct', 'id', 'product');
    }
}
