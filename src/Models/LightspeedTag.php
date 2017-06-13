<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedTag extends Model
{
    protected $table = 'lightspeed_tags';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'isVisible', 'url', 'title'];
    protected $guarded = ['products'];

    protected $casts = [
    ];

//    public function products()
//    {
//        return $this->hasMany('App\LightspeedTagsProduct', 'brand');
//    }
}
