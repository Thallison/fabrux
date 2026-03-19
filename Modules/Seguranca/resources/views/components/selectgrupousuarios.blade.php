<select name="perfil" {{ $attributes->merge(['class' => 'form-select']) }}  @error('perfil') is-invalid @enderror>
<option value="">{{ __('Selecione um perfil') }}</option>
@foreach($papeis as $id => $nome)

<option value="{{ $id }}"
    {{ $selected == $id ? 'selected' : '' }}>
    {{ $nome }}
</option>

@endforeach

</select>
@error('perfil')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror