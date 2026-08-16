<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class transactions extends Model
{
    protected $fillable = [
        'Total_Amount',
        'Paid_Amount',
        'Discount',
        'Total_Profit'
    ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return HasMany<transaction_items, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(transaction_items::class);
    }
}
