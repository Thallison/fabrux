@extends('layouts.default')

@section('page-title', 'Produção')

@section('content')

@can('Cadastrar Produção')
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Registrar Produção') }}</h5>
    </div>
    <form action="{{ route('producao::producoes.store') }}" method="POST">
        <div class="card-body">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('fun_id') }} <span class="text-danger">*</span></label>
                        <select name="fun_id" class="form-select @error('fun_id') is-invalid @enderror" required>
                            <option value="">{{ __('Selecione...') }}</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->fun_id }}" {{ old('fun_id') == $funcionario->fun_id ? 'selected' : '' }}>
                                    {{ $funcionario->fun_nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('fun_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('prod_id') }} <span class="text-danger">*</span></label>
                        <select name="prod_id" class="form-select @error('prod_id') is-invalid @enderror" required>
                            <option value="">{{ __('Selecione...') }}</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->prod_id }}" {{ old('prod_id') == $produto->prod_id ? 'selected' : '' }}>
                                    {{ $produto->prod_nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('prod_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('produ_quantidade') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('produ_quantidade') is-invalid @enderror" type="number" min="1" name="produ_quantidade" required value="{{ old('produ_quantidade') }}" />
                        @error('produ_quantidade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('produ_data') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('produ_data') is-invalid @enderror" type="date" name="produ_data" required value="{{ old('produ_data', now()->format('Y-m-d')) }}" />
                        @error('produ_data')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('produ_hora') }}</label>
                        <input class="form-control @error('produ_hora') is-invalid @enderror" type="time" name="produ_hora" value="{{ old('produ_hora') }}" />
                        @error('produ_hora')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('produ_tempo_gasto') }}</label>
                        <input class="form-control @error('produ_tempo_gasto') is-invalid @enderror" type="time" name="produ_tempo_gasto" value="{{ old('produ_tempo_gasto') }}" />
                        @error('temprodu_tempo_gastopo_gasto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Registrar produção') }}
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
                    data-url="{{ route('producao::producoes.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='produ_id'>
                                #
                            </th>
                            <th data-field='funcionario_nome'>
                                {{ __('Funcionário') }}
                            </th>
                            <th data-field='produto_nome'>
                                {{ __('Produto') }}
                            </th>
                            <th data-field='produ_quantidade'>
                                {{ $model->getAttributeLabel('produ_quantidade') }}
                            </th>
                            <th data-field='produ_data'>
                                {{ $model->getAttributeLabel('produ_data') }}
                            </th>
                            <th data-field='produ_hora'>
                                {{ $model->getAttributeLabel('produ_hora') }}
                            </th>
                            <th data-field='produ_tempo_gasto' data-formatter="App.segundosParaTime">
                                {{ $model->getAttributeLabel('produ_tempo_gasto') }}
                            </th>
                            <th data-field='created_at'>
                                {{ $model->getAttributeLabel('created_at') }}
                            </th>
                            @canany(['Editar Produções', 'Excluir Produções'])
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
    function TableActions(value, row, index) {
        let editar = excluir = '';
        let id = row['producao_id'];

        let urlEdit = "{{ route('producao::producoes.show', ['produco' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('producao::producoes.destroy', ['produco' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar Produções')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarProd_' + id + '" data-action="modal-editar-producao" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan

        @can('Excluir Produções')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteProd_' + id + '" data-action="excluir-producao" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
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
        App.modal(url);
    }

    function editar(action) {
        App.submitForm({
            form: 'form[name="editProducao"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirProducao(action) {
        App.confirm({
            title: "Excluir produção",
            message: "Deseja realmente excluir este registro de produção?",
            url: action.dataset.url,
            table: "gridTable"
        });
    }

    document.addEventListener("click", function(e) {
        const action = e.target.closest("[data-action]");

        if (!action) return;
        e.preventDefault();

        const tipo = action.dataset.action;

        switch (tipo) {
            case "modal-editar-producao":
                openEdit(action);
                break;
            case "editar-producao":
                editar(action);
                break;
            case "excluir-producao":
                excluirProducao(action);
                break;
        }
    });
</script>
@endpush
