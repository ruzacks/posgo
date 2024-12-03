<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($talents as $talent)
            <tr>
                <td>{{ $talent->name }}</td>
                <td>
                    <button type="button" 
                            class="btn btn-primary pick-talent-btn" 
                            data-talent-id="{{ $talent->id }}" 
                            data-talent-name="{{ $talent->name }}">
                        Pilih
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
