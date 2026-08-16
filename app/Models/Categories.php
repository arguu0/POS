<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $fillable = [ 'name' ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    
    /**
     * @return HasMany<ProductDatabase, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductDatabase::class, 'category_id');
    }
}
