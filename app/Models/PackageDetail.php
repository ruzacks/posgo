<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Talent;

class PackageDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'fixed_products' => 'object', // Cast to object instead of array
        'optional_products' => 'object',
        'optional_talents' => 'object',
    ];
    
    // Accessor for fixed_products
    public function getFixedProductsAttribute($value)
    {
        if (is_null($value)) {
            return []; // Return an empty array if the value is null
        }
    
        $fixedProducts = json_decode($value); // Decode JSON as object
    
        foreach ($fixedProducts as $item) {
            $product = Product::find($item->productId); // Find the Product instance
            if ($product) {
                $item->product = $product; // Attach Product instance
                $item->product->unit_name = $product->unit_id 
                    ? Unit::find($product->unit_id)->shortname ?? 'N/A' 
                    : 'N/A'; // Fetch and attach the unit name
            } else {
                $item->unit_name = 'N/A'; // Handle cases where the product is not found
            }
        }
    
        return $fixedProducts;
    }
    
    // Accessor for optional_products
    public function getOptionalProductsAttribute($value)
    {
        if (is_null($value)) {
            return []; // Return an empty array if the value is null
        }
    
        $optionalProducts = json_decode($value);
    
        foreach ($optionalProducts as $item) {
            foreach ($item->products as $productData) {
                $product = Product::find($productData->id); // Find the Product instance
                if ($product) {
                    $productData->product = $product; // Attach Product instance
                    $productData->product->unit_name = $product->unit_id 
                        ? Unit::find($product->unit_id)->shortname ?? 'N/A' 
                        : 'N/A'; // Fetch and attach the unit name
                } else {
                    $productData->unit_name = 'N/A'; // Handle cases where the product is not found
                }
            }
        }
    
        return $optionalProducts;
    }
    
    // Accessor for optional_talents
    public function getOptionalTalentsAttribute($value)
    {
        if (is_null($value)) {
            return []; // Return an empty array if the value is null
        }
    
        $optionalTalents = json_decode($value);
    
        foreach ($optionalTalents as $item) {
            $item->talent = TalentGrade::find($item->grade_id); // Attach Talent instance
        }
    
        return $optionalTalents;
    }
    
}
