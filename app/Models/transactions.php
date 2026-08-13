<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    protected $fillable = [
        'Total_Amount',
        'Paid_Amount',
        'Discount'
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function items() {
        return $this->hasMany(transaction_items::class);
    }
}
