<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(ProductDatabase::class, 'store_id');
    }
    public function categories()
    {
        return $this->hasMany(Categories::class, 'store_id');
    }
    public function transactions() {
        return $this->hasMany(transactions::class);
    }
}
