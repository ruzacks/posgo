<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Voucher')) {
            $vouchers = Voucher::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'DESC')->get();

            return view('vouchers.index')->with('vouchers', $vouchers);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('Create Voucher')) {
            return view('vouchers.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Voucher')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'voucher_code' => 'required|max:50|unique:vouchers,voucher_code',
                    'discount_type' => 'required|in:fixed,percentage',
                    'discount_value' => 'required|numeric|min:0',
                    'max_discount' => 'nullable|numeric|min:0',
                    'start_date' => 'required|date',
                    'expiry_date' => 'required|date|after_or_equal:start_date',
                    'usage_limit' => 'nullable|integer|min:0',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();

            $voucher = new Voucher();
            $voucher->voucher_code = $request->voucher_code;
            $voucher->discount_type = $request->discount_type;
            $voucher->discount_value = $request->discount_value;
            $voucher->max_discount = $request->max_discount ?: null;
            $voucher->start_date = $request->start_date;
            $voucher->expiry_date = $request->expiry_date;
            $voucher->usage_limit = $request->usage_limit ?: null;
            $voucher->is_active = 1;
            $voucher->created_by = $user->getCreatedBy();

            $voucher->save();

            return redirect()->route('vouchers.index')->with('success', __('Voucher added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Voucher $voucher)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Voucher $voucher)
    {
        if (Auth::user()->can('Edit Voucher')) {
            return view('vouchers.edit', compact('voucher'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Voucher $voucher)
    {
        if (Auth::user()->can('Edit Voucher')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'voucher_code' => 'required|max:50|unique:vouchers,voucher_code,' . $voucher->id,
                    'discount_type' => 'required|in:fixed,percentage',
                    'discount_value' => 'required|numeric|min:0',
                    'max_discount' => 'nullable|numeric|min:0',
                    'start_date' => 'required|date',
                    'expiry_date' => 'required|date|after_or_equal:start_date',
                    'usage_limit' => 'nullable|integer|min:0',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $voucher->voucher_code = $request->voucher_code;
            $voucher->discount_type = $request->discount_type;
            $voucher->discount_value = $request->discount_value;
            $voucher->max_discount = $request->max_discount ?: null;
            $voucher->start_date = $request->start_date;
            $voucher->expiry_date = $request->expiry_date;
            $voucher->usage_limit = $request->usage_limit ?: null;
            $voucher->is_active = 1;
            $voucher->save();

            return redirect()->route('vouchers.index')->with('success', __('Voucher updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Voucher $voucher)
    {
        if (Auth::user()->can('Delete Voucher')) {
            $voucher->delete();

            return redirect()->route('vouchers.index')->with('success', __('Voucher successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
