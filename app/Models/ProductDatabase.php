<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDatabase extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'stock'
    ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function items() {
        return $this->hasMany(transaction_items::class);
    }
}
