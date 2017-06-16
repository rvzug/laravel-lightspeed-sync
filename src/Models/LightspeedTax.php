<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;

class LightspeedTax extends Model
{
    protected $table = 'lightspeed_taxes';
    public $incrementing = false;
    protected $fillable = ['id', 'isDefault', 'rate', 'title'];

}
