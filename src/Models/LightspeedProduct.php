<?php

namespace Rvzug\LightspeedSync\Models;

use Illuminate\Database\Eloquent\Model;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedProduct extends Model
{
    use HasResourceAttributes;

    protected $table = 'lightspeed_products';
    public $incrementing = false;
    protected $fillable = ['id', 'createdAt', 'updatedAt', 'isVisible', 'visibility', 'data01', 'data02', 'data03', 'url', 'title', 'fulltitle', 'description', 'content', 'set', 'brand', 'deliverydate', 'image', 'type', 'supplier',];
    protected $guarded = ['brand', 'deliverydate', 'type', 'supplier'];
    protected $resources = ['brand', 'deliverydate', 'type', 'supplier'];
    public $submodels = [
        'attributes' => 'productsAttributes',
        'images' => 'productsImages',
//        'relations' => 'productsRelations',
    ];

    protected $casts = [
        'set' => 'array',
        'image' => 'array',
    ];

    public function categories()
    {
        return $this->hasManyThrough('App\LightspeedCategory', 'App\LightspeedCategoriesProduct', 'product', 'category');
    }

    public function images()
    {
        return $this->hasMany('App\LightspeedProductsImage', 'product');
    }

    public function relations()
    {
        return $this->hasManyThrough('App\LightspeedProduct', 'App\LightspeedProductsRelation', 'relatedProduct', 'product');
    }

    public function metafields()
    {
        return $this->morphMany('App\LightspeedMetafield', 'metafield', 'ownerType', 'ownerId');
    }

    public function reviews()
    {
        return $this->hasMany('App\LightspeedReview', 'product');
    }

    public function type()
    {
        return $this->belongsTo('App\LightspeedType', 'type');
    }

    public function attributes()
    {
        return $this->hasManyThrough('App\LightspeedAttribute', 'App\LightspeedProductAttribute', 'attribute', 'product');
    }

    public function productattributes()
    {
        return $this->hasMany('App\LightspeedProductAttribute', 'product', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\LightspeedSupplier', 'supplier');
    }

    public function tags()
    {
        return $this->hasManyThrough('App\LightspeedTag', 'App\LightspeedTagsProduct', 'tag', 'product');
    }

    public function variants()
    {
        return $this->hasMany('App\LightspeedVariant', 'product');
    }

//    public function attachAttributes($intermediate)
//    {
//        $productId = $this->id;
//
//        $productattribute = new LightspeedProductAttribute([
//            'value'=>$intermediate['value'],
//            'product'=>$productId,
//            'attribute'=>$intermediate['attribute']['id'],
//        ]);
//
//        $this->productattributes()->save($productattribute);
//    }
//
//    public function detachAttributes()
//    {
//        LightspeedProductAttribute::where('product', $this->id)->delete();
//    }
//
//    public function attachImages($intermediate)
//    {
//        $productId = $this->id;
//
//        $productimage = new LightspeedProductsImage([
//            'id'=>$intermediate['id'],
//            'product'=>$productId,
//            'sortOrder'=>$intermediate['sortOrder'],
//            'createdAt'=>$intermediate['createdAt'],
//            'updatedAt'=>$intermediate['updatedAt'],
//            'extension'=>$intermediate['extension'],
//            'size'=>$intermediate['size'],
//            'title'=>$intermediate['title'],
//            'thumb'=>$intermediate['thumb'],
//            'src'=>$intermediate['src'],
//        ]);
//
//        $this->images()->save($productimage);
//    }
//
//    public function detachImages()
//    {
//        LightspeedProductsImage::where('product', $this->id)->delete();
//    }
}
