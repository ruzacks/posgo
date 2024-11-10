{{ Form::open(['url' => 'location-price', 'id' => 'location-price-form']) }}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('duration', __('Duration (Hour)'), ['class' => 'col-form-label']) }}
        {{ Form::number('duration', null, ['class' => 'form-control', 'placeholder' => __('Enter Duration')]) }}
    </div>

    <div class="form-group">
        {{ Form::label('price', __('Price'), ['class' => 'col-form-label']) }}
        {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => __('Enter Price')]) }}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" id="submit-btn" value="{{ __('Create') }}" type="button">
</div>
{{ Form::close() }}

<script>
       $('#submit-btn').on('click', function() {
        let formData = new FormData($('#location-price-form')[0]);

        $.ajax({
            url: "{{ route('location-prices.store', $locationType->id) }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success) {
                    // alert('Location price created successfully!');

                    show_toastr('Success', data.message, 'success');
                    // Make a second request to fetch the updated location prices
                    $.ajax({
                        url: "{{ route('location-prices.index', $locationType->id) }}",
                        type: 'GET',
                        success: function(response) {
                            // Update commonModal modal body content with the result
                            $('#commonModal .modal-body').html(response);

                            // Toggle the visibility of secondaryModal
                            $('#secondaryModal').modal('toggle');

                        },
                        error: function(error) {
                            console.error('Error fetching location prices:', error);
                            show_toastr('Error',response, 'error')                        
                        }
                    });

                } else {
                    show_toastr('Error', data.message, 'error')                
                }
            },
            error: function(error) {
                console.error('Errorssssss');
                show_toastr('Error', error.message, 'error') 
            }
        });

    });
</script>
