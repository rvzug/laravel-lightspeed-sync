<?php

namespace Rvzug\LightspeedSync\Models;

use App\LightspeedIndexer\LightspeedIndexerGuardedAttributes;
use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedTypesAttribute extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_typesattributes';
    public $incrementing = false;
    protected $fillable = ['id', 'sortOrder'];
    protected $guarded = ['type', 'attribute'];
    protected $resources = ['type', 'attribute'];

    protected $casts = [
    ];

    public function type(){
        return $this->hasMany('App\LightspeedType', 'id', 'type');
    }

    public function attribute(){
        return $this->hasMany('App\LightspeedAttribute', 'id', 'attribute');
    }

}
