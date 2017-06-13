<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedCategory extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_categories';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'isVisible', 'depth', 'path', 'sortOrder', 'sorting', 'url', 'title', 'fulltitle', 'description', 'content', 'image'];
    protected $guarded = ['parent', 'children', 'products'];
    protected $resources = ['parent'];

    protected $casts = [
        'path' => 'array',
        'image' => 'array',
    ];

    public function children()
    {
        return $this->hasMany('App\LightspeedCategory', 'parent');
    }

}
