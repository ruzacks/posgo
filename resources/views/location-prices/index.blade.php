<div class="modal-body">
    <div class="text-end mb-2">
        @can('Manage Location')
            <a href="#" data-secondary-popup="true" data-size="md" 
                data-title="{{__('Add New Location Price')}}" title="{{__('Add New Location Price')}}" data-bs-toggle="tooltip" data-url="{{route('location-prices.create',$locationType->id)}}"
                class="btn btn-sm btn-primary btn-icon ">
                <span class=""><i class="ti ti-plus text-white"></i>{{ __('Add Price') }}</span>
            </a>
        @endcan
    </div>
    <div class="card">
        <div class="card-header card-body table-border-style">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Duration (Hour)') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locationPrices as $locationPrice)
                        <tr id="{{ $locationPrice->id }}">
                            <td>{{ $locationPrice->duration }}</td>
                            <td>{{ $locationPrice->price }}</td> 
                            <td>
                                @can('Manage Location')
                                <div class="action-btn btn-info ms-2">
                                    <a href="#" data-secondary-popup="true" data-size="md" 
                                        data-title="{{__('Edit Location Price')}}" title="{{__('Edit Location Price')}}" data-bs-toggle="tooltip" data-url="{{route('location-prices.edit',$locationPrice->id)}}"
                                        class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                        <span class=""><i class="ti ti-pencil text-white"></i></span>
                                    </a>
                                </div>

                                <div class="action-btn bg-danger ms-2">
                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                       data-bs-toggle="tooltip"
                                       title="{{ __('Delete') }}"
                                       onclick="deleteLocationPrice({{ $locationPrice->id }})">
                                        <i class="ti ti-trash text-white"></i>
                                    </a>
                                </div>
                                @endcan
                            </td>                           
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Are You Sure?') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('This action can not be undone. Do you want to continue?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">{{ __('Yes, delete it!') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteLocationPrice(id) {
    // Show the modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();

    // Handle the confirmation click
    document.getElementById('confirmDelete').addEventListener('click', function() {
        // Close the modal after the user confirms
        deleteModal.hide();

        // Make the AJAX request to delete the location price
        $.ajax({
            url: "{{ route('location-prices.destroy', ':id') }}".replace(':id', id),
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                show_toastr('Success', response.message, 'success');
                $('#' + id).remove();
            },
            error: function(error) {
                show_toastr('Error', error.message, 'error');
            }
        });
    });
}

</script>