<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PackageDetail;
use App\Models\Product;
use App\Models\TalentGrade;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackageDetailController extends Controller
{
    public function editPackage(Product $product)
    {
        $package = PackageDetail::firstOrNew(['product_id' => $product->id]);

        if (!$package->exists) {
            $package->save();
        }

        $talentGrades = TalentGrade::select('id', DB::raw('(talent_price + agency_price + office_price) AS price'))
        ->get();

        return view('package-details.edit', compact('product', 'package', 'talentGrades'));
    }

    public function updatePackage(Product $product, Request $request)
    {
        try {
            // Update product details
            $product->name = $request->package_name;
            $product->purchase_price = $request->hpp;
            $product->sale_price = $product->sale_price;
            $product->save();
    
            // Update package details
            $packageDetail = PackageDetail::where('product_id', $product->id)->first();
    
            if (!$packageDetail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Package detail not found.'
                ]);
            }
    
            $packageDetail->fixed_products = $request->fixed_product;
            $packageDetail->optional_products = $request->optional_product ?? null;
            $packageDetail->optional_talents = $request->talents ?? null;
            $packageDetail->duration = $request->duration;
            $packageDetail->save();
    
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil diperbarui.'
            ]);
    
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui paket.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    

    public function packageItems(Request $request)
    {
        $productId = $request->id;

        if ($request->has('field')) {
            
            if($request->field === 'fixed') {
                $items = PackageDetail::where('product_id', $productId)
                    ->value('fixed_products'); 
            } else if ($request->field === 'optional') {
                $items = PackageDetail::where('product_id', $productId)
                    ->value('optional_products'); 
            }

            if($items){
                $returnItems = [];
    
                    foreach ($items as $item) {
                    $product = Product::select('id', 'purchase_price', 'name')
                        ->where('id', $item->product_id)
                        ->first();
    
                    if ($product) {
                        $returnItems[] = [
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'purchase_price' => $product->purchase_price,
                            'quantity' => $item->quantity,
                            'subtotal' => $item->quantity * $product->purchase_price
                        ];
                    }
                }
    
                return response()->json($returnItems);
            }
        }
        

        // return response()->json(['error' => 'Invalid request'], 400);
    }

    public function addTalent(Request $request)
    {
        $user_id = Auth::user()->getCreatedBy();

        $grade = $request->grade;
        $qty = $request->quantity;
        if (Auth::user()->can('Create Product')) {
            $talentGrades = TalentGrade::pluck('name', 'id');
            $talentGrades->prepend(__('Select Grade'),'');

            return view('package-details.add-talent', compact('grade', 'qty', 'talentGrades'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function searchPackage(Request $request)
    {
        $packageId = Category::where('name', 'PAKET')->pluck('id')->first();

        $products = Product::where('category_id', $packageId)
            ->where('name', 'like', '%' . $request->search . '%')
            ->select('name', 'id', 'sale_price')->get(); // Correct order for pluck

        return response()->json($products); // Returning JSON for better API practices
    }

    public function getPackage(Request $request)
    {
        // Fix the typo in the variable name
        $package = Product::where('id', $request->package_id)->with('PackageDetail')->first();

        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404); // Handle null cases
        }

        // Use the correct relationship name and return the desired attribute
        return $package; 
    }
}
