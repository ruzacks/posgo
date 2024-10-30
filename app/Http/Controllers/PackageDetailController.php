<?php

namespace App\Http\Controllers;

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
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'min_sale' => 'required|integer|min:1',
            'fixed_product' => 'array', // Make optional
            'fixed_quantity' => 'array', // Make optional
            'fixed_quantity.*' => 'integer|min:1',
            'optional_product' => 'array', // Make optional
            'optional_quantity' => 'array', // Make optional
            'optional_quantity.*' => 'integer|min:1',
            'talent_grade' => 'array', // Make optional
            'talent_quantity' => 'array', // Make optional
            'talent_quantity.*' => 'integer|min:1',
        ]);

        $fixedProductsWithQuantities = [];
        $optionalProductsWithQuantities = [];
        $talentsWithQuantities = [];

        // Process fixed products and quantities if they are present
        if (!empty($validated['fixed_product']) && !empty($validated['fixed_quantity'])) {
            foreach ($validated['fixed_product'] as $index => $productId) {
                $fixedProductsWithQuantities[] = [
                    'product_id' => $productId,
                    'quantity' => $validated['fixed_quantity'][$index],
                ];
            }
        }

        // Process optional products and quantities if they are present
        if (!empty($validated['optional_product']) && !empty($validated['optional_quantity'])) {
            foreach ($validated['optional_product'] as $index => $productId) {
                $optionalProductsWithQuantities[] = [
                    'product_id' => $productId,
                    'quantity' => $validated['optional_quantity'][$index],
                ];
            }
        }

        // Process optional products and quantities if they are present
        if (!empty($validated['talent_grade']) && !empty($validated['talent_quantity'])) {
            foreach ($validated['talent_grade'] as $index => $productId) {
                $talentsWithQuantities[] = [
                    'grade_id' => $productId,
                    'quantity' => $validated['talent_quantity'][$index],
                ];
            }
        }

        $product->name = $request->name;
        $product->sale_price = $request->sale_price;
        $product->save();

        // Update the package details
        $package = PackageDetail::where('product_id', $product->id)->first();
        $package->fixed_products = $fixedProductsWithQuantities ?: null;
        $package->optional_products = $optionalProductsWithQuantities ?: null;
        $package->optional_talents = $talentsWithQuantities ?: null;
        $package->duration = $request->duration;
        $package->location = $request->location;
        $package->min_sale = $request->min_sale;
        $package->number_optional_choice = $request->number_optional_choice;
        $package->save();

        return redirect()->back()->with('success', __('Package Updated.'));
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
}
