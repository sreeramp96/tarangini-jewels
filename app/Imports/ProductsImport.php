<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $categoryName = $row['category'];
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            ['name' => $categoryName]
        );

        if (empty($row['name']) || empty($row['price']) || empty($row['stock'])) {
            Log::warning("Skipping row due to missing data: " . json_encode($row));
            return null;
        }

        $product = Product::create([
            'category_id'    => $category->id,
            'name'           => $row['name'],
            'slug'           => Str::slug($row['name']) . '-' . Str::random(5),
            'description'    => $row['description'] ?? null,
            'price'          => $row['price'],
            'discount_price' => $row['discount_price'] ?? null,
            'stock'          => $row['stock'],
            'is_featured'    => filter_var($row['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);

        // 3. Handle Images (Basic - Assumes images are pre-uploaded)
        // **IMPORTANT:** This part assumes image files listed in the CSV
        // are already uploaded to a *known location* (e.g., 'storage/app/public/import-images/').
        // You'll need a separate process to upload the actual image files.
        if (!empty($row['images'])) {
            $imageNames = explode('|', $row['images']);
            $isPrimary = true;
            foreach ($imageNames as $imageName) {
                $imageName = trim($imageName);
                // **Placeholder Logic:** You'd replace 'import-images/' with the actual path
                // and potentially move the file to the 'products/' directory.
                // For now, we just create the record.
                if (!empty($imageName)) {
                    $product->images()->create([
                        // 'image_path' => 'products/' . $imageName, // Example path after moving
                        'image_path' => 'import-images/' . $imageName, // Placeholder path
                        'is_primary' => $isPrimary,
                    ]);
                    $isPrimary = false;
                }
            }
        }

        return $product;
    }
}
