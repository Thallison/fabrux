@extends('layouts.default')

@section('page-title', 'Funcionários')

@section('content')
  
@can('Cadastrar Funcionarios') 
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Funcionários') }}</h5>
    </div>
    <form action="{{ route('cadastros::funcionarios.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('fun_nome') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('fun_nome') is-invalid @enderror" type="text" name="fun_nome" required  placeholder="{{ $model->getAttributeLabel('fun_nome') }}" value="{{ old('fun_nome') }}" />
                        @error('fun_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('fun_codigo') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('fun_codigo') is-invalid @enderror" type="text" name="fun_codigo" required  placeholder="{{ $model->getAttributeLabel('fun_codigo') }}" value="{{ old('fun_codigo') }}" />
                        @error('fun_codigo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('fun_carga_horaria') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('fun_carga_horaria') is-invalid @enderror" type="time" name="fun_carga_horaria" required  placeholder="{{ $model->getAttributeLabel('fun_carga_horaria') }}" value="{{ old('fun_carga_horaria') }}" />
                        @error('fun_carga_horaria')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('fun_ativo') }} <span class="text-danger">*</span></label>
                        <select name="fun_ativo" class="form-select" required  @error('fun_ativo') is-invalid @enderror>
                            <option value="">{{ __('Selecione...') }}</option>
                            <option value="1"
                                {{ old('fun_ativo') == 1 ? 'selected' : '' }}>
                                {{ __('Ativo') }}
                            </option>
                            <option value="0"
                                {{ old('fun_ativo') === 0 ? 'selected' : '' }}>
                                {{ __('Inativo') }}
                            </option>
                        </select>
                        @error('fun_ativo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
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
@endcan

<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Funcionários') }}</h5>
    </div>

    <div class="card-body">
        <div id="" class="">
            <div class="">
                <table class="table"
                    id="gridTable"
                    data-toggle="{{ __(config('bootstraptable.toggle')) }}"
                    data-search="{{ __(config('bootstraptable.search')) }}"
                    data-pagination="{{ __(config('bootstraptable.pagination')) }}"
                    data-page-size="{{ __(config('bootstraptable.page-size')) }}"
                    data-page-list="{{ __(config('bootstraptable.page-list')) }}"
                    data-show-columns="{{ __(config('bootstraptable.show-columns')) }}"
                    data-locale="{{ __(config('app.locale')) }}"
                    data-show-export="{{ __(config('bootstraptable.show-export')) }}"
                    data-export-data-type="{{ __(config('bootstraptable.export-data-type')) }}"
                    data-export-types="{{ __(config('bootstraptable.export-types')) }}"
                    data-show-toggle="{{ __(config('bootstraptable.show-toggle')) }}"
                    data-show-fullscreen="{{ __(config('bootstraptable.show-fullscreen')) }}"
                    data-show-refresh="{{ __(config('bootstraptable.show-refresh')) }}"
                    data-url="{{ route('cadastros::funcionarios.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='fun_id'>
                                #
                            </th>
                            <th data-field='fun_codigo'>
                                {{ $model->getAttributeLabel('fun_codigo') }}
                            </th>
                            <th data-field='fun_nome'>
                                {{ $model->getAttributeLabel('fun_nome') }}
                            </th>
                            <th data-field='fun_carga_horaria' data-formatter="App.segundosParaTime">
                                {{ $model->getAttributeLabel('fun_carga_horaria') }}
                            </th>
                            <th data-field='fun_ativo' data-formatter="App.tipoMensagem">
                                {{ $model->getAttributeLabel('fun_ativo') }}
                            </th>
                            <th data-field='created_at'>
                                {{ $model->getAttributeLabel('created_at') }}
                            </th>
                            @canany(['Editar Funcionarios', 'Excluir Funcionarios'])
                            <th data-formatter="TableActions" class="w-10">
                                {{ __('Ações') }}
                            </th>
                            @endcanany
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = excluir = '';
        let id = row['fun_id'];

        let urlEdit = "{{ route('cadastros::funcionarios.show', ['funcionario' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('cadastros::funcionarios.destroy', ['funcionario' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar Funcionarios')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarFun_'+ id +'" data-action="modal-editar-funcionario" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan

        @can('Excluir Funcionarios')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteFun_'+ id +'" data-action="excluir-funcionario" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
                +'<i class="bi bi-trash3-fill"></i>'
                +'</a>';
        @endcan
        
        return [
            '<div class="list-icons">',
            editar,
            excluir,
            '</div>'
        ].join('');

    }

    function openEdit(action) {
        let url = action.dataset.url;
        App.modal(url);//abrir modal com o formulário de edição
    }

    function editar(action) {
        /*Submeer formulario do modal*/
        App.submitForm({
            form: 'form[name="editFuncionario"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirFuncionario(action) {
        App.confirm({
            title: "Excluir funcionário",
            message: "Deseja realmente excluir este funcionário?",
            url: action.dataset.url,
            table: "gridTable"
        });
    }

     document.addEventListener("click", function(e){
        const action = e.target.closest("[data-action]");

        if(!action) return;
        e.preventDefault();

        const tipo = action.dataset.action;

        switch(tipo){
            case "modal-editar-funcionario":
                openEdit(action);
            break;

            case "editar-funcionario":
                editar(action);
            break;

            case "excluir-funcionario":
                excluirFuncionario(action);
            break;
        }
    });
</script>
@endpush