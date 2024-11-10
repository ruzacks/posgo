<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Location')) {            
            $numberOfLocations = $this->getNumberOfLocations();

            return view('locations.master')->with('numberOfLocations', $numberOfLocations);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function detailLocations(LocationType $locationType)
    {
        if (Auth::user()->can('Manage Location')) {
            $locations = Location::where('location_type_id', $locationType->id)->where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->get();
            return view('locations.index', compact('locations', 'locationType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('Create Location')) {
            return view('locations.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function createLocation(LocationType $type)
    {
        if (Auth::user()->can('Create Location')) {

            $lastNumber = $this->getLastNumber($type->id);

            $location = new Location();
            $location->code = $type->name . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);  // e.g., HALL-004
            $location->location_type_id = $type->id;
            $location->created_by = Auth::user()->getCreatedBy();
            $location->is_active = '1';
            $location->save();

            return redirect()->back()->with('success', __('Location added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Location')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'location_code' => 'required|max:120',
                    'type' => 'required',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();


            $location['location_code'] = $request->location_code;
            $location['type'] = $request->location_type;
            $location['price'] = $request->price;
            $location['is_active'] = 1;
            $location['created_by'] = $user->getCreatedBy();

            $location = Location::create($location);

            return redirect()->route('locations.index')->with('success', __('Location added successfully.'));
             
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Location $location)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Location $location)
    {
        if (Auth::user()->can('Edit Location')) {
            return view('locations.edit', compact('location'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Location $location)
    {
        if (Auth::user()->can('Edit Location')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'code' => 'required|max:120',
                    'status' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $location['code'] = $request->code;
            $location['status'] = $request->status;
            $location->save();

            return redirect()->back()->with('success', __('Location updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Location $location)
    {
        if (Auth::user()->can('Delete Location')) {
            $location->delete();

            return redirect()->route('locations.index')->with('success', __('Location successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function numberOfLocationUpdate(Request $request)
    {
        $numberOfLocations = $this->getNumberOfLocations();

        // Define location types and their prefixes
        $locationTypes = [
            'hall' => 'HALL',
            'room' => 'ROOM',
            'vip' => 'VIP',
        ];

        foreach ($locationTypes as $type => $prefix) {
            if ($request->has($type)) {
                $newLocationCount = $request->$type - $numberOfLocations->$type;

                if ($newLocationCount > 0) {
                    // Add locations
                    for ($i = 1; $i <= $newLocationCount; $i++) {
                        $lastNumber = $this->getLastNumber($type);

                        $location = new Location();
                        $location->code = $prefix . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);  // e.g., HALL-004
                        $location->type = $type;
                        $location->created_by = Auth::user()->getCreatedBy();
                        $location->is_active = '1';
                        $location->save();
                    }
                } elseif ($newLocationCount < 0) {
                    // Remove locations in reverse order
                    $locationsToDelete = Location::where('created_by', Auth::user()->getCreatedBy())
                                        ->where('type', $type)
                                        ->orderBy('code', 'desc')
                                        ->take(abs($newLocationCount))
                                        ->get();

                    foreach ($locationsToDelete as $location) {
                        $location->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', __('Location numbers updated successfully.'));
    }

    public function getNumberOfLocations()
    {
        $numberOfLocations = new \stdClass();

        $numberOfLocations->hall = Location::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'hall')
                                ->count();

        $numberOfLocations->location = Location::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'location')
                                ->count();

        $numberOfLocations->vip = Location::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'vip')
                                ->count();

        return $numberOfLocations;
    }

    public function getLastNumber($type)
    {
        // Get the last location code based on type and created_by
        $lastLocation = Location::where('created_by', Auth::user()->getCreatedBy())
                        ->where('location_type_id', $type)
                        ->orderByDesc('code')
                        ->first();

        // Extract and return the numeric part if it exists, otherwise return 0
        if ($lastLocation && preg_match('/(\d+)$/', $lastLocation->code, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }
}
