@extends('layouts.default')

@section('page-title', 'Funcionalidades')

@section('content')
    
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Editar Funcionalidades') }}</h5>
        <div class="text-end">
            <a href="{{ route('seguranca::funcionalidades.index') }}" class="btn btn-info"><i class="bi bi-arrow-left"></i> {{ __('Listar Funcionalidade') }}</a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
    </div>
    <form action="{{ route('seguranca::funcionalidades.update', ['funcionalidade' => $dados->func_id]) }}" method="POST">
        <div class="card-body ">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('func_label')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('func_label') is-invalid @enderror" type="text" name="func_label" required  placeholder="{{ __($model->getAttributeLabel('func_label')) }}" value="{{ $dados->func_label }}" />
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
                        <input class="form-control @error('func_controller') is-invalid @enderror" type="text" name="func_controller" placeholder="{{ __($model->getAttributeLabel('func_controller')) }}" value="{{ $dados->func_controller }}" />
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
                    <input class="form-control @error('func_icon') is-invalid @enderror" type="text" name="func_icon" placeholder="{{ __($model->getAttributeLabel('func_icon')) }}" value="{{ $dados->func_icon }}" />
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
                        :selected="$dados->mod_id"
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
                        {{ $dados->func_id_pai == $id ? 'selected' : '' }}>
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
                    <input class="form-control @error('func_rota_padrao') is-invalid @enderror" type="text" name="func_rota_padrao" placeholder="{{ __($model->getAttributeLabel('func_rota_padrao')) }}" value="{{ $dados->func_rota_padrao }}" />
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
                            {{ $dados->func_acesso_menu == 1 ? 'selected' : '' }}>
                            {{ __('Sim') }}
                        </option>
                        <option value="0"
                            {{ $dados->func_acesso_menu === 0 ? 'selected' : '' }}>
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
                            {{ $dados->func_tipo == 'Controller' ? 'selected' : '' }}>
                            {{ __('Controller') }}
                        </option>
                        <option value="Service"
                            {{ $dados->func_tipo == 'Service' ? 'selected' : '' }}>
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

            <div class="row mb-3 table-responsive"">
                <table class="table table-hover" id="privilegios_cadastrados">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center">Privilégios Cadastrados</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Nome do Privilégio</th>
                            <th>Action do Privilégio</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse  ($dados->privilegios()->get() as $i => $priv)
                        <tr>
                            <td>{{ $priv->priv_id }}</td>
                            <td>{{ $priv->priv_label }}</td>
                            <td>{{ $priv->priv_action }}</td>
                            <td>
                                <div class="icons-list">
                                    <a class="btn btn-outline-info btn-sm" data-action="edit-priv" data-url="{{ route('seguranca::privilegios.show', ['privilegio' => $priv->priv_id]) }}"
                                        href="#" title="{{ __('Editar privilegio') }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-outline-danger btn-sm" data-action="delete-priv" data-url="{{ route('seguranca::privilegios.destroy', ['privilegio' => $priv->priv_id]) }}"
                                        data-method="DELETE" href="#" title="{{ __('Excluir privilegio') }}">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum privilegio encontrado!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row mb-3" id="div_privilegios"></div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <a class="btn btn-info" id="adicionar_privilegios"><i class="bi bi-plus"></i> {{ __('Adicionar privilégio') }}</a>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Editar') }}
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    //Adicionar botões de ações quando carregar o modal para editar o privilegio
    document.addEventListener("modal:loaded", function(){
        App.dynamicFields({
            addButton: "#adicionar_dep_privilegios",
            container: "#div_dep_privilegios",
            template: (index) => `
                <div class="row mb-3 dynamic-item">

                    <div class="col-md-4 form-group">
                        <input type="text"
                            id="depPrivLabel_${index}"
                            name="depPrivilegios[${index}][dep_priv_controller]"
                            placeholder="Controller dependência"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-4 form-group">
                        <input type="text"
                            id="depPrivAction_${index}"
                            name="depPrivilegios[${index}][dep_priv_action]"
                            placeholder="Action da Dependência"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-4 form-group">
                        <a href="#" class="btn btn-danger btn-sm" data-action="remove-item">
                            <i class="bi bi-x"></i>
                        </a>
                    </div>
                </div>
            `
        });
        
    });

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

    function openEdit(action) {
        let url = action.dataset.url;
        App.modal(url);//abrir modal com o formulário de edição
    }

    function excluirFuncionalidade(action) {
        const rows = document.querySelectorAll('#privilegios_cadastrados tbody tr');

        if (rows.length === 1) {

            App.message(
                'Não é possivel excluir o privilégio. A funcionalidade deve possuir no mínimo 1 privilégio.',
                'warning'
            );

            return;
        }

        App.confirm({
            url: btn.dataset.url,
            body: 'Deseja realmente excluir o privilégio?'
        }, 'danger', btn);
    }

    function editar(action) {
        /*Submeer formulario do modal*/
        App.submitForm({
            form: 'form[name="editPrivilegio"]',
            modal: '#modal_default',
            reload: true,
            method: 'PUT'
        });
    }

    function deleteDepPrivilegio(action) {
        App.confirm({
            reload: true,
            url: action.dataset.url,
            body: 'Deseja realmente excluir a dependência do privilégio?'
        }, 'danger', action);
    }

    document.addEventListener("click", function (e) {

        const btn = e.target.closest("[data-action]");
        if (!btn) return;

        e.preventDefault();

        const tipo = btn.dataset.action;

        switch(tipo){
            case "delete-priv":
                excluirFuncionalidade(btn);
            break;
            case "edit-priv":
                openEdit(btn);
            break;
            case "editar-privilegio":
                editar(btn);
            break;
            case "deleteDepPrivilegio":
                deleteDepPrivilegio(btn);
        }

    });
</script>
@endpush