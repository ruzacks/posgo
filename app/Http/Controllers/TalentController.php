<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Talent;
use App\Models\TalentGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TalentController extends Controller
{
    public function getLastNumber()
    {
        // Get the last room code based on type and created_by
        $lastNumber = Talent::where('created_by', Auth::user()->getCreatedBy())
                        ->orderByDesc('code')
                        ->first();

        // Extract and return the numeric part if it exists, otherwise return 0
        if ($lastNumber && preg_match('/(\d+)$/', $lastNumber->code, $matches)) {
            return 'TLN-' . str_pad((int) $matches[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'TLN-' . str_pad(0 + 1, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        if (Auth::user()->can('Manage Talent')) {
            $talents = Talent::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->get();

            return view('talents.index')->with('talents', $talents);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        $newCode = $this->getLastNumber();
        
        $user_id = Auth::user()->getCreatedBy();

        if (Auth::user()->can('Create Talent')) {
            $grades = TalentGrade::where('created_by', $user_id)->pluck('name', 'id');
            $grades->prepend(__('Select Grade'), '');

            $agencies = Agency::where('created_by', $user_id)->pluck('name', 'id');
            $agencies->prepend(__('Select Agency'), '');

            return view('talents.create', compact('grades','agencies','newCode'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Talent')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    // 'phone_number' => 'required|min:10|max:15',
                    'code' => 'required|max:120',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();

            $talent['code'] = $request->code;
            $talent['name'] = $request->name;
            $talent['phone_number'] = $request->phone_number;
            $talent['address'] = $request->address;
            $talent['grade_id'] = $request->grade_id;
            $talent['agency_id'] = $request->agency_id;
            $talent['is_active'] = 1;
            $talent['created_by'] = $user->getCreatedBy();

            if (!empty($request->input('grade_id'))) {
                $talent['grade_id'] = $request->grade_id;
            }

            $talent = Talent::create($talent);

            return redirect()->route('talents.index')->with('success', __('Talent added successfully.'));
             
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Talent $talent)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Talent $talent)
    {
        $user_id = Auth::user()->getCreatedBy();

        if (Auth::user()->can('Create Talent')) {
            $grades = TalentGrade::where('created_by', $user_id)->pluck('name', 'id');
            $grades->prepend(__('Select Grade'), '');

            $agencies = Agency::where('created_by', $user_id)->pluck('name', 'id');
            $agencies->prepend(__('Select Agency'), '');

            return view('talents.edit', compact('talent','grades','agencies'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Talent $talent)
    {
        if (Auth::user()->can('Edit Talent')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    // 'phone_number' => 'required|min:10|max:15',
                    'code' => 'required|max:120',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }


            $talent['name'] = $request->name;
            $talent['phone_number'] = $request->phone_number;
            $talent['address'] = $request->address;
            $talent['grade_id'] = $request->grade_id;
            $talent['agency_id'] = $request->agency_id;
            $talent['is_active'] = 1;

            if (!empty($request->input('grade_id'))) {
                $talent['grade_id'] = $request->grade_id;
            }

            if (!empty($request->input('agency_id'))) {
                $talent['agency_id'] = $request->agency_id;
            }
            
            $talent->save();

            return redirect()->route('talents.index')->with('success', __('Talent updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Talent $talent)
    {
        if (Auth::user()->can('Delete Talent')) {
            $talent->delete();

            return redirect()->route('talents.index')->with('success', __('Talent successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function searchTalents(Request $request)
    {
        if (Auth::user()->can('Manage Talent')) {
            $talents = [];
            $search    = $request->search;
            if ($request->ajax() && isset($search) && !empty($search)) {
                $talents = Talent::select('id as value', 'name as label')->where('is_active', '=', 1)->where('name', 'LIKE', '%' . $search . '%')->get();

                return json_encode($talents);
            }

            return $talents;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getByGrade(Request $request)
    {
        $gradeId = $request->input('grade_id');
    
        // Check if grade_id is provided
        if ($gradeId) {
            // Fetch talents by grade
            $talents = Talent::where('grade_id', $gradeId)->get();
    
            // Check if any talents were found for the grade
            if ($talents->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No talents found for the specified grade.',
                ]);
            }
    
            // Return talents as a JSON response
            return response()->json([
                'success' => true,
                'talents' => $talents,
            ]);
        } else {
            // If grade_id is not provided, fetch all talents with their grade information
            $talents = TalentGrade::with('talent')->get();
    
            // Return talents as a JSON response
            return response()->json([
                'success' => true,
                'talents' => $talents,
            ]);
        }
    }
    
}
