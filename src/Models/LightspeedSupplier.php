<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedSupplier extends Model
{
    protected $table = 'lightspeed_suppliers';
    public $incrementing = false;
    protected $fillable = ['id', 'title', 'createdAt', 'updatedAt'];

    public function __construct()
    {
    }

    public function products()
    {
        return $this->hasMany('App\LightspeedProduct', 'brand');
    }
}
