<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class transaction_items extends Model
{
    protected $fillable = [
        'product_name',
        'product_price',
        'product_quantity',
        'subtotal'
    ];
    
    /**
     * @return BelongsTo<transactions, $this>
     */
    public function transactions(): BelongsTo
    {
        return $this->belongsTo(transactions::class);
    }

    /**
     * @return BelongsTo<ProductDatabase, $this>
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductDatabase::class);
    }
}
