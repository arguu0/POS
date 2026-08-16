<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany<ProductDatabase, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductDatabase::class, 'store_id');
    }

    /**
     * @return HasMany<Categories, $this>
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Categories::class, 'store_id');
    }

    /**
     * @return HasMany<transactions, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(transactions::class);
    }
}
