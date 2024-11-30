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
            $item->product = Product::find($item->productId); // Attach Product instance
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
                $productData->product = Product::find($productData->id); // Attach Product instance
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
            $item->talent = Talent::find($item->grade_id); // Attach Talent instance
        }
    
        return $optionalTalents;
    }
    
}
