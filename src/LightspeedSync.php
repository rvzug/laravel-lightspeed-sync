<?php

namespace Rvzug\LightspeedSync;

use Rvzug\LightspeedSync\Models\LightspeedBrand;
use Rvzug\LightspeedSync\Models\LightspeedCategoriesProduct;
use Rvzug\LightspeedSync\Models\LightspeedCategory;
use Rvzug\LightspeedSync\Models\LightspeedDeliverydate;
use Rvzug\LightspeedSync\Models\LightspeedMetafield;
use Rvzug\LightspeedSync\Models\LightspeedProduct;
use Rvzug\LightspeedSync\Models\LightspeedReview;
use Rvzug\LightspeedSync\Models\LightspeedSupplier;
use Rvzug\LightspeedSync\Models\LightspeedTag;
use Rvzug\LightspeedSync\Models\LightspeedType;
use Rvzug\LightspeedSync\Models\LightspeedTypesAttribute;
use Rvzug\LightspeedSync\Models\LightspeedVariant;
use Rvzug\LightspeedSync\Models\LightspeedVariantsMovement;

class LightspeedSync
{
    const MODEL_BY_RESOURCE = [
        'deliverydates' => LightspeedDeliverydate::class,
        'brands' => LightspeedBrand::class,
        'suppliers' => LightspeedSupplier::class,
        'categories' => LightspeedCategory::class,
        'types' => LightspeedType::class,
        'tags' => LightspeedTag::class,
        'reviews' => LightspeedReview::class,
        'typesattributes' => LightspeedTypesAttribute::class,
        'categoriesproducts' => LightspeedCategoriesProduct::class,
        'metafields' => LightspeedMetafield::class,
        'variantsmovements' => LightspeedVariantsMovement::class,
        'products' => LightspeedProduct::class,
        'variants' => LightspeedVariant::class,
    ];

    const CHILDRESOURCES = [
        'products' => ['productsAttributes', 'productsImages'],
        'variants' => []
    ];

    public function __construct()
    {
    }

    public function init(array $arg)
    {
        // load standalone resources
        LightspeedSyncFacade::getAll('deliverydates');
        LightspeedSyncFacade::getAll('brands');
        LightspeedSyncFacade::getAll('suppliers');
        LightspeedSyncFacade::getAll('categories');
        LightspeedSyncFacade::getAll('types');
        LightspeedSyncFacade::getAll('tags');
        LightspeedSyncFacade::getAll('reviews');
        LightspeedSyncFacade::getAll('typesattributes');
        LightspeedSyncFacade::getAll('categoriesproducts');
        LightspeedSyncFacade::getAll('metafields');
        LightspeedSyncFacade::getAll('variantsmovements');

        LightspeedSyncFacade::getAllWithChildResources('products', self::CHILDRESOURCES['product']);
        LightspeedSyncFacade::getAllWithChildResources('variants', self::CHILDRESOURCES['product']);
        // load complex resources
            // with childmodels


    }

    public static function in($resource, $id = null, $data = [])
    {
        $class = class_name(self::MODEL_BY_RESOURCE[$resource]);

        if ($id)
            $instance = $class::findOrFail($id);
        else
            $instance = new $class;

        $instance->fill($data);
        $instance->save();
    }

    public static function out($resource, $id, $create = false, $attributes = [])
    {
        $class = class_name(self::MODEL_BY_RESOURCE[$resource]);
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

    public static function getChildresources($resource = null)
    {
        if(!$resource)
        {
            return self::CHILDRESOURCES;
        }
        else {
            return self::CHILDRESOURCES[$resource];
        }
    }

}