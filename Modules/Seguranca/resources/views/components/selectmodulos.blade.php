<select name="mod_id" {{ $attributes->merge(['class' => 'form-select']) }}  @error('mod_id') is-invalid @enderror>
<option value="">{{ __('Selecione um módulo') }}</option>
@foreach($modulos as $id => $nome)

<option value="{{ $id }}"
    {{ $selected == $id ? 'selected' : '' }}>
    {{ $nome }}
</option>

@endforeach

</select>
@error('sis_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror