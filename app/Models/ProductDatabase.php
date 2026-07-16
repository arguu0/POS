<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDatabase extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
