<?php

namespace App\Http\Controllers;

use App\Models\SalePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalePaymentController extends Controller
{
    public function index(Request $request)
    {
        $saleId = $request->sale_id;

        // Fetch all payments for the given sale ID
        $payments = SalePayment::where('sale_id', $saleId)->get();

        // Render a Blade view for the modal content
        return view('sale_payments.list', compact('payments'))->render();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sale_id' => 'required|integer|exists:sales,id',
            'pay_type' => 'required|string|in:card,cash',
            'card_number' => 'nullable|string|size:16',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        try {
            // Create payment record
            $payment = new SalePayment();
            $payment->sale_id = $validatedData['sale_id'];
            $payment->pay_type = $validatedData['pay_type'];
            $payment->card_number = $validatedData['pay_type'] === 'card' ? $validatedData['card_number'] : null;
            $payment->amount = $validatedData['amount'];
            $payment->created_by = Auth::user()->id;
            $payment->description = $validatedData['description'];
            $payment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment successfully recorded.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
