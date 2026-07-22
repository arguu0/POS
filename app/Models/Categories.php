<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [ 'name' ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    
    public function products()
    {
        return $this->hasMany(ProductDatabase::class, 'category_id');
    }
}
