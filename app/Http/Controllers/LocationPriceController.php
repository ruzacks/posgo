<?php

namespace App\Http\Controllers;

use App\Models\LocationPrice;
use App\Models\LocationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LocationPriceController extends Controller
{
    public function index(LocationType $locationType)
    {
        if (Auth::user()->can('Manage Location')) {
            $locationPrices = LocationPrice::where('location_type_id', $locationType->id)->get();
            
            return view('location-prices.index', compact('locationPrices', 'locationType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create(LocationType $locationType)
    {
        if (Auth::user()->can('Manage Location')) {
            return view('location-prices.create', compact('locationType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(locationType $locationType, Request $request)
    {
        $request->validate([
            'duration' => [
                'required',
                Rule::unique('location_prices')->where(function ($query) use ($request) {
                    return $query->where('location_type_id', $request->location_type_id);
                })
            ],
            'price' => 'required|numeric',
        ]);
        
        try {
            $locationPrice = new LocationPrice;
            $locationPrice->location_type_id = $locationType->id;
            $locationPrice->duration = $request->duration;
            $locationPrice->price = $request->price;
        
            if ($locationPrice->save()) {
                // Return success JSON response
                return response()->json([
                    'success' => true,
                    'message' => 'Location price created successfully!',
                    'data' => $locationPrice
                ], 201); // HTTP 201 Created
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle the unique constraint violation exception
            if ($e->getCode() === '23000') { // 23000 is the SQLSTATE code for integrity constraint violation
                return response()->json([
                    'success' => false,
                    'message' => 'The combination of location type and duration must be unique.'
                ]); // HTTP 422 Unprocessable Entity
            }
        
            // Return a general failure JSON response if another error occurs
            return response()->json([
                'success' => false,
                'message' => 'Failed to create location price due to a database error.'
            ]); // HTTP 500 Internal Server Error
        }
    }

    public function edit(LocationPrice $locationPrice)
    {
        if (Auth::user()->can('Manage Location')) {
            return view('location-prices.edit', compact('locationPrice'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(LocationPrice $locationPrice, Request $request)
    {
        $request->validate([
            'duration' => [
                'required',
                Rule::unique('location_prices')->where(function ($query) use ($request) {
                    return $query->where('location_type_id', $request->location_type_id);
                })
            ],
            'price' => 'required|numeric',
        ]);
        
        try {
            $locationPrice->duration = $request->duration;
            $locationPrice->price = $request->price;
        
            if ($locationPrice->save()) {
                // Return success JSON response
                return response()->json([
                    'success' => true,
                    'message' => __('Location price updated successfully!'),
                    'data' => $locationPrice
                ], 201); // HTTP 201 Created
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle the unique constraint violation exception
            if ($e->getCode() === '23000') { // 23000 is the SQLSTATE code for integrity constraint violation
                return response()->json([
                    'success' => false,
                    'message' => __('The combination of location type and duration must be unique.')
                ]); // HTTP 422 Unprocessable Entity
            }
        
            // Return a general failure JSON response if another error occurs
            return response()->json([
                'success' => false,
                'message' => __('Failed to create location price due to a database error.')
            ]); // HTTP 500 Internal Server Error
        }
    }

    public function destroy(LocationPrice $locationPrice)
    {
        if (Auth::user()->can('Delete Location')) {
            $locationPrice->delete();
            return response()->json([
                'success' => true,
                'message' => __('Location price deleted successfully!'),
                'data' => $locationPrice
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => __('Permission denied.')
            ]);

        }
    }
}
