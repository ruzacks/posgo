<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgencyController extends Controller
{
    public function getLastNumber()
    {
        // Get the last room code based on type and created_by
        $lastNumber = Agency::where('created_by', Auth::user()->getCreatedBy())
                        ->orderByDesc('code')
                        ->first();

        // Extract and return the numeric part if it exists, otherwise return 0
        if ($lastNumber && preg_match('/(\d+)$/', $lastNumber->code, $matches)) {
            return 'AGC-' . str_pad((int) $matches[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'AGC-' . str_pad(0 + 1, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        if (Auth::user()->can('Manage Agency')) {
            $agencies = Agency::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->get();

            return view('agencies.index')->with('agencies', $agencies);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        $newCode = $this->getLastNumber();

        if (Auth::user()->can('Create Agency')) {
            return view('agencies.create',compact('newCode'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Agency')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'code' => 'required|unique:agencies,code',
                    // 'phone_number' => 'required|min:10|max:15',
                    // 'address' => 'required|max:255',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $agency = new Agency();
            $agency->name = $request->name;
            $agency->code = $request->code;
            $agency->phone_number = $request->phone_number;
            $agency->address = $request->address;
            $agency->is_active = 1;
            $agency->created_by = Auth::user()->getCreatedBy();
            $agency->save();

            return redirect()->route('agencies.index')->with('success', __('Agency added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Agency $agency)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Agency $agency)
    {
        if (Auth::user()->can('Edit Agency')) {
            return view('agencies.edit', compact('agency'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Agency $agency)
    {
        if (Auth::user()->can('Edit Agency')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'code' => 'required|unique:agencies,code,' . $agency->id,
                    // 'phone_number' => 'required|min:10|max:15',
                    // 'address' => 'required|max:255',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $agency->name = $request->name;
            $agency->code = $request->code;
            $agency->phone_number = $request->phone_number;
            $agency->address = $request->address;
            $agency->is_active = $request->is_active ?? 1;
            $agency->save();

            return redirect()->route('agencies.index')->with('success', __('Agency updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Agency $agency)
    {
        if (Auth::user()->can('Delete Agency')) {
            $agency->delete();

            return redirect()->route('agencies.index')->with('success', __('Agency successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

}
