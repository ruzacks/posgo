<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LocationTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Location Type')) {
            $location_types = LocationType::where('created_by', '=', Auth::user()->getCreatedBy())
                                          ->orderBy('id', 'DESC')
                                          ->withCount('location')
                                          ->get();

            return view('location-types.index', compact('location_types'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('Create Location Type')) {
            return view('location-types.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Location Type')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:location_types,name,NULL,id,created_by,' . Auth::user()->getCreatedBy(),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $locationType             = new LocationType();
            $locationType->name       = $request->name;
            $locationType->slug       = Str::slug($request->name, '-');
            $locationType->created_by = Auth::user()->getCreatedBy();
            $locationType->save();

            return redirect()->route('location-types.index')->with('success', __('Location Type added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(LocationType $locationType)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(LocationType $locationType)
    {
        if (Auth::user()->can('Edit Location Type')) {
            return view('location-types.edit', compact('locationType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, LocationType $locationType)
    {
        if (Auth::user()->can('Edit Location Type')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:location_types,name,' . $locationType->id . ',id,created_by,' . Auth::user()->getCreatedBy(),
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $locationType->name = $request->name;
            $locationType->slug = Str::slug($request->name, '-');
            $locationType->save();

            return redirect()->route('location-types.index')->with('success', __('Location Type updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(LocationType $locationType)
    {
        if (Auth::user()->can('Delete Location')) {
            $locations = Location::where('created_by', Auth::user()->getCreatedBy())
                                 ->where('location_type_id', $locationType->id)
                                 ->where('status', '<>', 'available')
                                 ->count();
    
            if ($locations > 0) {
                return redirect()->back()->with('error', __('Pastikan seluruh lokasi di ') . "$locationType->name " . __('tidak dalam transaksi dan maintenance.'));
            }
    
            Location::where('location_type_id', $locationType->id)->delete();
    
            $locationType->delete();
    
            return redirect()->route('location-types.index')->with('success', __('Location Type deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
