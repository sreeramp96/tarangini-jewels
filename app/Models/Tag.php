<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'type'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }
}
