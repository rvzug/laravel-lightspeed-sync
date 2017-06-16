<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightspeedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('lightspeed_products', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->boolean('isVisible');
            $table->enum('visibility', array("hidden", "visible", "auto"));
            $table->longText('data01');
            $table->longText('data02');
            $table->longText('data03');
            $table->string('url');
            $table->string('title');
            $table->string('fulltitle');
            $table->longText('description');
            $table->longText('content');
            $table->json('set');
            $table->integer('brand')->unsigned();
            $table->integer('deliverydate')->unsigned();
            $table->json('image');
            $table->integer('type')->unsigned();
            $table->integer('supplier')->unsigned();
            // Product Movement is strange....
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_variants', function (Blueprint $table){
            $table->integer('id')->unsigned()->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->boolean('isDefault');
            $table->integer('sortOrder')->unsigned();
            $table->string('articleCode');
            $table->string('ean');
            $table->string('sku');
            $table->double('priceExcl');
            $table->double('priceIncl');
            $table->double('priceCost');
            $table->double('oldPriceExcl');
            $table->double('oldPriceIncl');
            $table->enum('stockTracking', array("disabled", "enabled", "indicator"));
            $table->integer("stockLevel");
            $table->integer("stockAlert");
            $table->integer("stockMinimum");
            $table->integer("stockSold");
            $table->integer("stockBuyMinimum")->unsigned();
            $table->integer("stockBuyMaximum")->unsigned();
            $table->float("weight")->nullable();
            $table->double("weightValue")->nullable();
            $table->enum("weightUnit", array("kg", "oz", "lb", "g"))->nullable();
            $table->integer("volume")->unsigned()->nullable();
            $table->double("volumeValue")->nullable();
            $table->string("volumeUnit")->nullable();
            $table->integer("colli")->unsigned()->nullable();
            $table->integer("sizeX")->unsigned()->nullable();
            $table->integer("sizeY")->unsigned()->nullable();
            $table->integer("sizeZ")->unsigned()->nullable();
            $table->double("sizeXValue")->nullable();
            $table->double("sizeYValue")->nullable();
            $table->double("sizeZValue")->nullable();
            $table->string("sizeUnit")->nullable();
            $table->string("matrix", 3)->nullable(); //enum dataviolation can't see why!
            $table->string("title");
            $table->longText("taxType")->nullable(); // unknown datatype!!
            $table->json("image");
            $table->double('unitPrice')->nullable();
            $table->enum('unitUnit', array('Centimeter', 'Decimeter', 'Foot', 'Hectometer', 'Inch', 'Kilometer', 'Meter', 'Micrometer', 'Mile', 'Millimeter', 'Yard', 'Acre', 'Are', 'Hectares', 'Square centimeter', 'Square feet', 'Square inch', 'Square kilometer', 'Square meter', 'Square mile', 'Square millimeter', 'Square yard', 'Carat', 'Gram', 'Kilogram', 'Milligram', 'Ounce', 'Pound', 'Stone', 'Ton', 'Tones', 'Cubic centiliter', 'Cubic centimeter', 'Cubic decimeter', 'Cubic decameter', 'Cubic feet', 'Cubic inch', 'Cubic meter', 'Cubic millimeter', 'Cubic Yard', 'Deciliter', 'Gallon', 'Liter', 'Milliliter', 'Piece', 'Pair', 'Capsule', 'Tablet'))->nullable()->default(null);
            $table->json('options');
            $table->integer('tax')->unsigned();
            $table->integer('product')->unsigned();
            // lightspeed_metafields >> vid references id on lightspeed_variants
            $table->integer('additionalcost')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_categoriesproducts', function(Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('sortOrder')->unsigned();
            $table->integer('category')->unsigned();
            $table->integer('product')->unsigned();
            $table->timestamps();
        });

        Schema::create('lightspeed_categories', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt')->nullable(); //nullable due to data inconsistency lightspeed
            $table->string('updatedAt');
            $table->boolean('isVisible');
            $table->integer('depth')->unsigned();
            $table->json('path');
            $table->enum('type', array("index", "textpage", "category"));
            $table->integer('sortOrder')->unsigned();
            $table->string('sorting');
            $table->string('url');
            $table->string('title');
            $table->string('fulltitle');
            $table->text('description');
            $table->longtext('content');
            $table->json('image');
            $table->integer('parent')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_productimages', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->integer('product')->unsigned();
            $table->integer('sortOrder')->unsigned()->nullable();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->string('extension')->nullable();
            $table->integer('size');
            $table->string('title');
            $table->string('thumb');
            $table->string('src');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_productrelations', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->integer('product')->unsigned();
            $table->integer('sortOrder')->unsigned();
            $table->integer('relatedProduct')->unsigned();
            $table->timestamps();
        });

        Schema::create('lightspeed_reviews', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->boolean('isVisible');
            $table->enum('score', array(1, 2, 3, 4, 5));
            $table->string('name');
            $table->longText('content');
            $table->json('language');
            $table->json('customer');
            $table->integer('product')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('lightspeed_types', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_typesattributes', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->integer('sortorder')->unsigned();
            $table->integer('type')->unsigned();
            $table->integer('attribute')->unsigned();
            $table->timestamps();
        });

        Schema::create('lightspeed_attributes', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('title');
            $table->string('defaultValue');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_productattributes', function(Blueprint $table){
            $table->increments('id')->unsigned(); // Lightspeed does not return a ProductAttibuteId but the attribute id.
            $table->integer('product')->unsigned();
            $table->integer('attribute')->unsigned();
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('lightspeed_tags', function (Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->boolean('isVisible');
            $table->string('url');
            $table->string('title');
            // products in model
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('lightspeed_tagproducts', function (Blueprint $table){
            $table->integer('id')->primary();
            $table->integer('tag')->unsigned();
            $table->integer('product')->unsigned();
            $table->timestamps();
        });

        Schema::create('lightspeed_variantmovements', function (Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->enum('channel', array('manual', 'auto', 'api'));
            $table->integer('stockLevelChange');
            $table->integer('product')->unsigned();
            $table->integer('variant')->unsigned();
            $table->timestamps();
        });

        Schema::create('lightspeed_brands', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->string('url');
            $table->string('title');
            $table->longText('content');
            $table->json('image');
            // products in model
            $table->boolean('isVisible');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_suppliers', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_deliverydates', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->string('name');
            $table->string('inStockMessage');
            $table->string('outStockMessage');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_metafields', function(Blueprint $table){
            $table->integer('id')->primary();
            $table->string('createdAt');
            $table->string('updatedAt');
            $table->enum('ownerType', ['shop', 'api', 'customer', 'order', 'invoice', 'shipment', 'category', 'product', 'variant', 'textpage', 'blog', 'article', 'tag']);
            $table->integer('ownerId')->unsigned();
            $table->string('key');
            $table->text('value');
            $table->json('ownerResource');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lightspeed_taxes', function(Blueprint $table) {
            $table->integer('id')->primary();
            $table->boolean('isDefault');
            $table->float('rate')->nullable();
            $table->string('title');
            $table->timestamps();
        });


        /****  foreign keys *****/
        Schema::table('lightspeed_products', function ( $table) {
            $table->foreign('brand')->references('id')->on('lightspeed_brands');
            $table->foreign('deliverydate')->references('id')->on('lightspeed_deliverydates');
            $table->foreign('type')-> references('id')->on('lightspeed_types');
            $table->foreign('supplier')-> references('id')->on('lightspeed_suppliers');

        });

        Schema::table('lightspeed_variants', function ( $table) {
            $table->foreign('tax')->references('id')->on('lightspeed_taxes');
            $table->foreign('product')->references('id')->on('lightspeed_products');
        });

        Schema::table('lightspeed_categoriesproducts', function ( $table) {
            $table->foreign('category')->references('id')->on('lightspeed_categories');
            $table->foreign('product')->references('id')->on('lightspeed_products');
        });

        Schema::table('lightspeed_categories', function ( $table){
            $table->foreign('parent')->references('id')->on('lightspeed_categories');
        });
        Schema::table('lightspeed_productimages', function( $table) {
            $table->foreign('product')->references('id')->on('lightspeed_products');
        });
        Schema::table('lightspeed_productrelations', function( $table) {
            $table->foreign('product')->references('id')->on('lightspeed_products');
            $table->foreign('relatedProduct')->references('id')->on('lightspeed_products');
        });
        Schema::table('lightspeed_reviews', function( $table) {
            $table->foreign('product')->references('id')->on('lightspeed_products');
        });
        Schema::table('lightspeed_productattributes', function( $table) {
            $table->foreign('product')->references('id')->on('lightspeed_products');
            $table->foreign('attribute')->references('id')->on('lightspeed_attributes');
        });
        Schema::table('lightspeed_typesattributes', function( $table) {
            $table->foreign('type')->references('id')->on('lightspeed_types');
            $table->foreign('attribute')->references('id')->on('lightspeed_attributes');
        });
        Schema::table('lightspeed_tagproducts', function( $table) {
            $table->foreign('tag')->references('id')->on('lightspeed_tags');
            $table->foreign('product')->references('id')->on('lightspeed_products');
        });
        Schema::table('lightspeed_variantmovements', function( $table) {
            $table->foreign('product')->references('id')->on('lightspeed_products');
            $table->foreign('variant')->references('id')->on('lightspeed_variants');
        });


        /*
         *
         * SEED ORDER:
         * ..lightspeed_categories
         * ..lightspeed_reviews
         * ..lightspeed_types
         * ..lightspeed_tags
         * ..lightspeed_brands
         * ..lightspeed_suppliers
         * ..lightspeed_deliverydates
         *
         * DEPENDS ON ABOVE
         * ..lightspeed_attributes
         *
         * DEPENDS ON lightspeed_types and lightspeed_attributes
         * ..lightspeed_typesattributes
         *
         * DEPENDS ON PRODUCTS
         * ..lightspeed_categoriesproducts    (????)
         * lightspeed_productimages         (per product)
         * lightspeed_productrelations      (???)
         * lightspeed_productattributes     (per product ???)
         *
         * lightspeed_variants              (eager)
         *
         * DEPENDS ON VARIANTS
         *
         */



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('lightspeed_products');
        Schema::dropIfExists('lightspeed_variants');
        Schema::dropIfExists('lightspeed_categoriesproducts');
        Schema::dropIfExists('lightspeed_categories');
        Schema::dropIfExists('lightspeed_productimages');
        Schema::dropIfExists('lightspeed_productrelations');
        Schema::dropIfExists('lightspeed_reviews');
        Schema::dropIfExists('lightspeed_types');
        Schema::dropIfExists('lightspeed_typesattributes');
        Schema::dropIfExists('lightspeed_attributes');
        Schema::dropIfExists('lightspeed_productattributes');
        Schema::dropIfExists('lightspeed_tags');
        Schema::dropIfExists('lightspeed_tagproducts');
        Schema::dropIfExists('lightspeed_variantmovements');
        Schema::dropIfExists('lightspeed_brands');
        Schema::dropIfExists('lightspeed_suppliers');
        Schema::dropIfExists('lightspeed_deliverydates');
    }
}
