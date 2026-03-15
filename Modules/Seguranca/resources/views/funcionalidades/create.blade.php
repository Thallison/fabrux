@extends('layouts.default')

@section('page-title', 'Funcionalidades')

@section('content')

@if (!$modulos)
    <div class="alert alert-info alert-styled-left alert-dismissible alert-important">
        <span class="font-weight-semibold">Aviso</span>
            Para cadastrar uma funcionalidade é necessário ter pelo menos um modulo cadastrado,
        <a href="{{ route('seguranca::modulos.index') }}" class="alert-link">Clique aqui para cadastrar um modulo.</a>
    </div>
@else
    
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Funcionalidades') }}</h5>
    </div>
    <form action="{{ route('seguranca::funcionalidades.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('func_label')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('func_label') is-invalid @enderror" type="text" name="func_label" required  placeholder="{{ __($model->getAttributeLabel('func_label')) }}" value="{{ old('func_label') }}" />
                        @error('func_label')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('func_controller')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('func_controller') is-invalid @enderror" type="text" name="func_controller" placeholder="{{ __($model->getAttributeLabel('func_controller')) }}" value="{{ old('func_controller') }}" />
                        @error('func_controller')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class='form-group'>
                    <label class="form-label">{{ __($model->getAttributeLabel('func_icon')) }} : </label>
                    <input class="form-control @error('func_icon') is-invalid @enderror" type="text" name="func_icon" placeholder="{{ __($model->getAttributeLabel('func_icon')) }}" value="{{ old('func_icon') }}" />
                    @error('func_icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __($model->getAttributeLabel('mod_id')) }} : <span class="text-danger">*</span></label>
                    <x-seguranca::select-modulos
                        :modulos="$modulos"
                        :selected="old('mod_id') ?? null"
                        class="filter"
                        required
                    />
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __($model->getAttributeLabel('func_id_pai')) }} : </label>

                    <select name="func_id_pai" class="form-select"  @error('func_id_pai') is-invalid @enderror>
                    <option value="">{{ __('Selecione...') }}</option>
                    @foreach($funcAll as $id => $nome)

                    <option value="{{ $id }}"
                        {{ old('func_id_pai') == $id ? 'selected' : '' }}>
                        {{ $nome }}
                    </option>

                    @endforeach

                    </select>
                    @error('func_id_pai')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __($model->getAttributeLabel('func_rota_padrao')) }} : </label>
                    <input class="form-control @error('func_rota_padrao') is-invalid @enderror" type="text" name="func_rota_padrao" placeholder="{{ __($model->getAttributeLabel('func_rota_padrao')) }}" value="{{ old('func_rota_padrao') }}" />
                    @error('func_rota_padrao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __($model->getAttributeLabel('func_acesso_menu')) }} : <span class="text-danger">*</span> </label>
                    <select name="func_acesso_menu" class="form-select"  @error('func_acesso_menu') is-invalid @enderror>
                        <option value="">{{ __('Selecione...') }}</option>
                        <option value="1"
                            {{ old('func_acesso_menu') == 1 ? 'selected' : '' }}>
                            {{ __('Sim') }}
                        </option>
                        <option value="0"
                            {{ old('func_acesso_menu') === 0 ? 'selected' : '' }}>
                            {{ __('Não') }}
                        </option>
                    </select>
                    @error('func_acesso_menu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __($model->getAttributeLabel('func_tipo')) }} : <span class="text-danger">*</span> </label>
                    <select name="func_tipo" class="form-select"  @error('func_tipo') is-invalid @enderror>
                        <option value="">{{ __('Selecione...') }}</option>
                        <option value="Controller"
                            {{ old('func_tipo') == 'Controller' ? 'selected' : '' }}>
                            {{ __('Controller') }}
                        </option>
                        <option value="Service"
                            {{ old('func_tipo') == 'Service' ? 'selected' : '' }}>
                            {{ __('Service') }}
                        </option>
                    </select>
                    @error('func_tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="row mb-3" id="div_privilegios">
                <div class="col-md-12">
                    <h5>{{ __('Privilégios') }}</h5>
                </div>

                 <div class="row mb-3">
                    <div class="col-md-3 form-group">
                        <label class="form-label">Nome do Privilégio: <span class="text-danger">*</span></label>
                        <input type="text" id="privLabel_0" name="privilegios[0][priv_label]" placeholder="Nome do Privilégio" class="form-control" required="required" value="{{ old('privilegios.0.priv_label') }}" >
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label">Action do Privilégio: <span class="text-danger">*</span></label>
                        <input type="text" id="privAction_0" name="privilegios[0][priv_action]" placeholder="Action do Privilégio" class="form-control" required="required" value="{{ old('privilegios.0.priv_action') }}" >
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <a class="btn btn-info" id="adicionar_privilegios"><i class="bi bi-plus"></i> {{ __('Adicionar privilégio') }}</a>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

@endif
@endsection

@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        App.dynamicFields({
            addButton: "#adicionar_privilegios",
            container: "#div_privilegios",
            template: (index) => `
                <div class="row mb-3 dynamic-item">

                    <div class="col-md-3 form-group">
                        <input type="text"
                            id="privLabel_${index}"
                            name="privilegios[${index}][priv_label]"
                            placeholder="Nome do Privilégio"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-3 form-group">
                        <input type="text"
                            id="privAction_${index}"
                            name="privilegios[${index}][priv_action]"
                            placeholder="Action do Privilégio"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-3 form-group">
                        <a href="#" class="btn btn-danger btn-sm" data-action="remove-item">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </div>
            `
        });
    });
</script>
@endpush