<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedReview extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_reviews';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'isVisible', 'score', 'name', 'content', 'customer', 'language', 'customer'];
    protected $guarded = ['product'];
    protected $resources = ['product'];

    protected $casts = [
        'customer' => 'array',
        'language' => 'array',
    ];

    public function product()
    {
        return $this->hasOne('App\LightspeedProduct', 'id', 'product');
    }
}
