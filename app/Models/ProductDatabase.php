<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductDatabase extends Model
{
    protected $fillable = [
        'name',
        'selling_price',
        'buying_price',
        'category_id',
        'profit',
    ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    /**
     * @return BelongsTo<Categories, $this>
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /**
     * @return HasMany<transaction_items, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(transaction_items::class);
    }
}
