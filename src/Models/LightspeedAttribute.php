<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedAttribute extends Model
{
    protected $table = 'lightspeed_attributes';
    public $incrementing = false;
    protected $fillable = ['id', 'title', 'defaultValue'];
    protected $guarded = ['types'];

    protected $casts = [
    ];

    public function types(){
        return $this->belongsToMany('App\LightspeedTypes', 'lightspeed_typesattributes', 'attribute', 'type');
    }
}
