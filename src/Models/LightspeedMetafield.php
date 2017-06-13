<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedMetafield extends Model
{
    protected $table = 'lightspeed_metafields';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'ownerType', 'ownerId', 'key', 'value', 'ownerResource'];

    protected $casts = [
        'ownerResource' => 'array',
    ];

    public function metafield()
    {
        return $this->morphTo('metafield', 'ownerType', 'ownerId');
    }
}
