<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction_items extends Model
{
    protected $fillable = [
        'product_name',
        'product_price',
        'product_quantity',
        'subtotal'
    ];
    
    public function transactions() {
        return $this->belongsTo(transactions::class);
    }

    public function products() {
        return $this->belongsTo(ProductDatabase::class);
    }
}
