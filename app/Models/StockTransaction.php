<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'type',
        'quantity',
        'description',
        'reference_number',
        'received_at',
        'status',
        'notes',
        'product_match',
        'attribute_match',
        'quantity_match',
        'condition',
        'inspection_notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'received_at' => 'datetime',
        'product_match' => 'boolean',
        'attribute_match' => 'boolean',
        'quantity_match' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}