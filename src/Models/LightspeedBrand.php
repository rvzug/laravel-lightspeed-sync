<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedBrand extends Model
{
    protected $table = 'lightspeed_brands';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'url', 'title', 'content', 'isVisible', 'image'];
    protected $guarded = ['products'];

    protected $casts = [
        'image' => 'array',
    ];

    public function products()
    {
        return $this->hasMany('App\LightspeedProduct', 'brand');
    }

}
