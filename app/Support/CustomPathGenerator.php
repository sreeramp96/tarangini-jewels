<?php

namespace App\Support;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // Save Product images in: products/{id}/
        if ($media->model_type === 'App\Models\Product') {
            return 'products/' . $media->id . '/';
        }

        // Save Category images in: categories/{id}/
        if ($media->model_type === 'App\Models\Category') {
            return 'categories/' . $media->id . '/';
        }

        // Default fallback: {id}/
        return $media->id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}
