<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
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
    public function getPrimaryImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('products');
        if ($media instanceof Media) {
            if ($media->hasGeneratedConversion('small')) {
                return $media->getFullUrl('small');
            }
            return $media->getFullUrl();
        }

        $media = $this->getFirstMedia('images');
        if ($media instanceof Media) {
            if ($media->hasGeneratedConversion('small')) {
                return $media->getFullUrl('small');
            }
            return $media->getFullUrl();
        }

        $img = $this->images()->first();
        if ($img && !empty($img->image_path)) {
            try {
                return Storage::disk('s3')->url($img->image_path);
            } catch (\Exception $e) {
                return $img->image_path;
            }
        }

        // 4) final fallback
        return asset('images/necklace.jpg');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->width(400)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(800);
    }
}
