<?php

namespace Rvzug\LightspeedSync;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;
use Rvzug\LightspeedSync\Jobs\LightspeedSyncCount;
use Rvzug\LightspeedSync\Jobs\LightspeedSyncGet;
use Rvzug\LightspeedSync\Jobs\LightspeedSyncGetPage;
use Rvzug\LightspeedSync\Models\LightspeedBrand;
use Rvzug\LightspeedSync\Models\LightspeedCategoriesProduct;
use Rvzug\LightspeedSync\Models\LightspeedCategory;
use Rvzug\LightspeedSync\Models\LightspeedDeliverydate;
use Rvzug\LightspeedSync\Models\LightspeedMetafield;
use Rvzug\LightspeedSync\Models\LightspeedProduct;
use Rvzug\LightspeedSync\Models\LightspeedProductsImage;
use Rvzug\LightspeedSync\Models\LightspeedReview;
use Rvzug\LightspeedSync\Models\LightspeedSupplier;
use Rvzug\LightspeedSync\Models\LightspeedTag;
use Rvzug\LightspeedSync\Models\LightspeedTax;
use Rvzug\LightspeedSync\Models\LightspeedType;
use Rvzug\LightspeedSync\Models\LightspeedTypesAttribute;
use Rvzug\LightspeedSync\Models\LightspeedVariant;
use Rvzug\LightspeedSync\Models\LightspeedVariantsMovement;
use Rvzug\LightspeedSync\Traits\HasGuardedAttributes;
use Rvzug\LightspeedSync\Traits\HasResourceAttributes;

class LightspeedSync
{
    const MODEL_BY_RESOURCE = [
        'deliverydates' => LightspeedDeliverydate::class,
        'brands' => LightspeedBrand::class,
        'suppliers' => LightspeedSupplier::class,
        'categories' => LightspeedCategory::class,
        'types' => LightspeedType::class,
        'tags' => LightspeedTag::class,
        'taxes' => LightspeedTax::class,
        'reviews' => LightspeedReview::class,
        'typesattributes' => LightspeedTypesAttribute::class,
        'categoriesproducts' => LightspeedCategoriesProduct::class,
        'metafields' => LightspeedMetafield::class,
        'variantsmovements' => LightspeedVariantsMovement::class,
        'productsImages' => LightspeedProductsImage::class,
        'products' => LightspeedProduct::class,
        'variants' => LightspeedVariant::class,
    ];

    const CHILDRESOURCES = [
        'products' => ['productsImages'],
    ];

    const CHILDRESOURCE_PARENT_ATTRIBUTE = [
        'productsImages' => 'product',
    ];

    public function __construct()
    {
    }

    public function init(array $arg)
    {
        // load standalone resources
        self::getAll('deliverydates');
        self::getAll('brands');
        self::getAll('suppliers');
        self::getAll('categories');
        self::getAll('types');
        self::getAll('tags');
        self::getAll('taxes');
        self::getAll('reviews');
        self::getAll('typesattributes');
        self::getAll('categoriesproducts');
        self::getAll('metafields');
        self::getAll('variantsmovements');

        // load complex resources - with childresources
        self::getAllWithChildResources('products');
        self::getAll('variants');
        
    }

    public function in($resource, $id = null, $data = [], $parentResourceId = null)
    {
        $model = self::MODEL_BY_RESOURCE[$resource];

        if ($id) {
            $instance = $model::findOrNew($id);
        } else {
            $instance = new $model;
        }

        if ($parentResourceId!==null && array_key_exists($resource, self::CHILDRESOURCE_PARENT_ATTRIBUTE))
        {
            $data[self::CHILDRESOURCE_PARENT_ATTRIBUTE[$resource]] = $parentResourceId;
        }

        $instance->fill($data);

        if(in_array(HasGuardedAttributes::class, class_uses($instance)) || in_array(HasResourceAttributes::class, class_uses($instance)))
            $instance->processGuardedAttributes($data);

        $instance->save();
    }

    public function out($resource, $id, $create = false, $attributes = [])
    {
        $class = self::MODEL_BY_RESOURCE[$resource];
        $instance = $class::findOrFail($id);
        if($create)
        {
            // do api request create
        }
        else {
            if(is_array($attributes) || count($attributes) > 1)
            {
                // filter model against attributes
            }

            // do api request update with (filtered) attributes
        }

    }

    public function getChildresources($resource = null)
    {
        if(!$resource)
        {
            return self::CHILDRESOURCES;
        }
        else {
            return self::CHILDRESOURCES[$resource];
        }
    }

    public function count($resource, $params = [])
    {
        // well, don't know any logical needs for this but...
        dispatch(new LightspeedSyncCount($resource, $params, false));
    }

    public function get($resource, $id = null, $params = [])
    {
        if($id == null)
            self::getAll($resource, $params);

        dispatch(new LightspeedSyncGet($resource, $id, $params));
    }

    public function getAll($resource, $params = [])
    {
        dispatch(new LightspeedSyncCount($resource, $params, true, false));
    }

    public function getAllWithChildResources($resource, $params = [])
    {

        dispatch(new LightspeedSyncCount($resource, $params, true, self::CHILDRESOURCES[$resource]));
    }

    public function getPage($resource, $page = 1, $param = [], $childresources = false)
    {
        dispatch(new LightspeedSyncGetPage($resource, $page, $param, $childresources));
    }

}