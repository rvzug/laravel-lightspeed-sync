<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedVariantsMovement extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_variantmovements';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'channel', 'stockLevelChange'];
    protected $guarded = ['product', 'variant'];
    protected $resources = ['product', 'variant'];

    protected $casts = [
        'image' => 'array',
        'options' => 'array',
    ];

}
