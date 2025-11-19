<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getPrimaryImageUrlAttribute()
    {
        if ($this->images->isEmpty()) {
            return asset('images/necklace.jpg');
        }

        $path = $this->images->first()->image_path;

        // Check if it's an external URL (fake data)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Get the Cloud URL (automatically handles the path)
        return Storage::disk('s3')->url($path);
    }
}
