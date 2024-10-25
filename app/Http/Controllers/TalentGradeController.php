<?php

namespace App\Http\Controllers;

use App\Models\TalentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TalentGradeController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('Manage Talent Grade'))
        {
            $talentGrades = TalentGrade::where('created_by', Auth::user()->id)
                                    ->orderBy('id', 'DESC')
                                    ->get();

            return view('talent-grades.index')->with('talentGrades', $talentGrades);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(Auth::user()->can('Create Talent Grade'))
        {
            return view('talent-grades.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('Create Talent Grade'))
        {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:100|unique:talent_grades,name,NULL,id,created_by,' . Auth::user()->id,
                    'price' => 'nullable|numeric|min:0',
                ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $grade = new TalentGrade();
            $grade->name = $request->name;
            $grade->price = $request->price ?: null;
            $grade->created_by = Auth::user()->getCreatedBy();
            $grade->save();

            return redirect()->route('talent-grades.index')->with('success', __('Talent grade added successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(TalentGrade $talentGrade)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(TalentGrade $talentGrade)
    {
        if(Auth::user()->can('Edit Talent Grade'))
        {
            return view('talent-grades.edit', compact('talentGrade'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, TalentGrade $talentGrade)
    {
        if(Auth::user()->can('Edit Talent Grade'))
        {
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:100|unique:talent_grades,name,' . $talentGrade->id . ',id,created_by,' . Auth::user()->id,
                    'price' => 'nullable|numeric|min:0',
                ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $talentGrade->name = $request->name;
            $talentGrade->price = $request->price ?: null;
            $talentGrade->save();

            return redirect()->route('talent-grades.index')->with('success', __('Talent grade updated successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(TalentGrade $talentGrade)
    {
        if(Auth::user()->can('Delete Talent Grade'))
        {
            $talentGrade->delete();

            return redirect()->route('talent-grades.index')->with('success', __('Talent grade deleted successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
