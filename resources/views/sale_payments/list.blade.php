<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Payment Type</th>
            <th>Card Number</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalAmount = 0; // Initialize the total amount
        @endphp

        @forelse($payments as $payment)
            @php
                $totalAmount += $payment->amount; // Add each payment's amount to the total
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->pay_type }}</td>
                <td>{{ $payment->card_number ?? '-' }}</td>
                <td>{{ Auth::user()->priceFormat($payment->amount) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No payments found.</td>
            </tr>
        @endforelse
    </tbody>
    @if($totalAmount > 0)
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>{{ Auth::user()->priceFormat($totalAmount) }}</th>
            </tr>
        </tfoot>
    @endif
</table>
