<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [

        'name',

        'sku',

        'category_id',

        'description',

        'price',

        'stock',

        'minimum_stock',

        'unit',

        'image',

        'status',
    ];


    protected $casts = [

        'price' =>
            'decimal:2',

        'stock' =>
            'integer',

        'minimum_stock' =>
            'integer',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class
        );
    }


    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttribute::class,
            'product_attribute_product'
        )
        ->withPivot(
            'product_attribute_value_id'
        )
        ->withTimestamps();
    }


    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'product_attribute_product',
            'product_id',
            'product_attribute_value_id'
        )
        ->withPivot(
            'product_attribute_id'
        )
        ->withTimestamps();
    }


    public function stockTransactions(): HasMany
    {
        return $this->hasMany(
            StockTransaction::class
        );
    }
}