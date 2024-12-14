@foreach ($locations as $key => $location)
    @php
        // Generate random check-in time within a specific range
        $randomCheckIn = \Carbon\Carbon::now()->subDays(rand(0, 5))->setTime(rand(0, 23), rand(0, 59));
        // Set check-out 2 hours after check-in
        $randomCheckOut = $randomCheckIn->copy()->addHours(2);
        // Determine color based on location status
        $statusColor = '';
        switch ($location->status) {
            case 'occupied':
                
                $statusColor = 'text-success'; // Green for occupied
                
                break;
            case 'booked':
                
                $statusColor = 'text-warning'; // Yellow for booked
                
                break;
            case 'available':
                
                $statusColor = 'text-info'; // Blue for available
                break;
            case 'maintenance':
                
                $statusColor = 'text-secondary'; // Gray for maintenance
                break;
            default:
                
                $statusColor = 'text-muted'; // Default for unknown status
                break;
        }
    @endphp
    <tr>
        <td>{{ $key + 1 }}</td>
        <td class="code-cell">{{ $location->code }}</td>
        <td class="{{ $statusColor }}">{{ $location->status }}</td>
        <td>{{ Auth::user()->priceFormat($location->getLatestSaleTotal()) }}</td>
        <td>{{ $location->getLatestSaleCheckIn() }}</td>
        {{-- <td></td> --}}
        <td class="elapsed-time" 
            data-start="{{ $location->latestSale ? $location->latestSale->check_in : '' }}">
        </td>
        <td>
            <div class="d-flex justify-content-center align-items-center gap-2">
                @if ($location->is_active == 1)
                    {{-- @can('Edit Location')
                        <div class="action-btn btn-info">
                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                data-ajax-popup="true" title="{{ __('Edit Location') }}"
                                data-title="{{ __('Edit Location') }}" data-size="lg"
                                data-url="{{ route('locations.edit', $location->id) }}"
                                data-bs-toggle="tooltip" title="{{ __('Edit Location') }}">
                                <i class="ti ti-pencil text-white"></i>
                            </a>
                        </div>
                    @endcan --}}
                                
                    <!-- Money Badge Button -->
                    @if($location->status == 'available')
                    
                        <a href="{{ route('sales.index', ['location_id' => $location->id]) }}"
                            class="mx-3 btn-sm btn-primary d-inline-flex align-items-center"
                            title="{{ __('Transaction') }}">
                            check-in</i>
                        </a>
                    @else
                    
                        <a href="#" class="mx-3 btn-sm btn-success d-inline-flex align-items-center" 
                            title="{{ __('Transaction') }}"
                            onclick="toggleWindow({{ $location->id }})">
                            add-item/check-out</i>
                        </a>
                    
                    @endif
                @else
                    <a href="#" class="btn btn-danger btn-sm">
                        <i class="fa fa-lock"></i>
                    </a>
                @endif
            </div>
        </td>
    </tr>
@endforeach