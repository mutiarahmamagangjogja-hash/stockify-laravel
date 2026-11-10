<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductAttribute extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(
            ProductAttributeValue::class
        );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_attribute_product'
        )
        ->withPivot('product_attribute_value_id')
        ->withTimestamps();
    }
}