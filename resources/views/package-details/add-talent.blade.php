<tr>
    <td>{{ Form::select('talent_grade[]', $talentGrades, $grade, ['class' => 'form-control talent-grade-select', 'required' => '']) }}</td>
    {{-- <td class="price-cell"></td> --}}
    <td>{{ Form::number('talent_quantity[]', $qty ?? 1, ['class' => 'form-control talent-quantity-input', 'min' => 1, 'required' => '']) }}</td>
    {{-- <td class="total-cell"></td> --}}
    <td>
        <button class="action-btn bg-danger remove-row">
            <i class="ti ti-trash text-white"></i>
        </button>
    </td>
</tr>
