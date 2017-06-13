<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedVariant extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_variants';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'isDefault', 'sortOrder', 'articleCode', 'ean', 'sku', 'url', 'unitPrice', 'unitUnit', 'priceExcl', 'priceIncl', 'priceCost', 'oldPriceExcl', 'oldPriceIncl', 'stockTracking', 'stockLevel', 'stockAlert', 'stockMinimum', 'stockSold', 'stockBuyMinimum', 'stockBuyMaximum', 'weight', 'weightValue', 'weightUnit', 'volume', 'volumeValue', 'volumeUnit', 'colli', 'sizeX', 'sizeY', 'sizeZ', 'sizeXValue', 'sizeYValue', 'sizeZValue', 'sizeUnit', 'matrix', 'title', 'taxType', 'image', 'options'];
    protected $guarded = ['tax', 'product', 'additionalcost'];
    protected $resources = ['tax', 'product', 'additionalcost'];

    protected $casts = [
        'image' => 'array',
        'options' => 'array',
    ];

}
