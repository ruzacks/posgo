<div class="modal-body p-4">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach($locations as $index => $locationType)
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                    id="pills-{{ $locationType->slug }}-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-{{ $locationType->slug }}" 
                    type="button" 
                    role="tab" 
                    aria-controls="pills-{{ $locationType->slug }}" 
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                    {{ $locationType->name }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="pills-tabContent">
        @foreach($locations as $index => $locationType)
            <div 
                class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                id="pills-{{ $locationType->slug }}" 
                role="tabpanel" 
                aria-labelledby="pills-{{ $locationType->slug }}-tab">
                @if($locationType->location->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locationType->location as $location)
                                <tr>
                                    <td>{{ $location->code }}</td>
                                    <td>{{ ucfirst($location->status) }}</td>
                                    <td>
                                        @if($location->status == 'available')
                                            <button class="btn btn-primary btn-sm" onclick="pickLocation('{{ $location->id }}')">Pick</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No locations available for this type.</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
