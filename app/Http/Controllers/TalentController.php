<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use App\Models\TalentGrade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TalentController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Talent')) {
            $talents = Talent::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'DESC')->get();

            return view('talents.index')->with('talents', $talents);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        $user_id = Auth::user()->getCreatedBy();

        if (Auth::user()->can('Create Talent')) {
            $grades = TalentGrade::where('created_by', $user_id)->pluck('name', 'id');
            $grades->prepend(__('Select Grade'), '');

            return view('talents.create', compact('grades'));
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
                    'phone_number' => 'required|min:10|max:15',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();

            $talent['name'] = $request->name;
            $talent['phone_number'] = $request->phone_number;
            $talent['address'] = $request->address;
            $talent['price'] = $request->price;
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

            return view('talents.edit', compact('talent','grades'));
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
                    'phone_number' => 'required|min:10|max:15',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }


            $talent['name'] = $request->name;
            $talent['phone_number'] = $request->phone_number;
            $talent['address'] = $request->address;
            $talent['price'] = $request->price;
            $talent['is_active'] = 1;

            if (!empty($request->input('grade_id'))) {
                $talent['grade_id'] = $request->grade_id;
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
}
