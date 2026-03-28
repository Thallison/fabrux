@extends('layouts.default')

@section('page-title', 'Produtos')

@section('content')

@can('Cadastrar Produtos') 
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Produtos') }}</h5>
    </div>
    <form action="{{ route('cadastros::produtos.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('prod_nome') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('prod_nome') is-invalid @enderror" type="text" name="prod_nome" required placeholder="{{ $model->getAttributeLabel('prod_nome') }}" value="{{ old('prod_nome') }}" />
                        @error('prod_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('prod_codigo') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('prod_codigo') is-invalid @enderror" type="text" name="prod_codigo" required placeholder="{{ $model->getAttributeLabel('prod_codigo') }}" value="{{ old('prod_codigo') }}" />
                        @error('prod_codigo')
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
                        <label class="form-label">{{ $model->getAttributeLabel('prod_tempo_estimado') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('prod_tempo_estimado') is-invalid @enderror" type="time" name="prod_tempo_estimado" required placeholder="{{ $model->getAttributeLabel('prod_tempo_estimado') }}" value="{{ old('prod_tempo_estimado') }}" />
                        @error('prod_tempo_estimado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('prod_ativo') }} <span class="text-danger">*</span></label>
                        <select name="prod_ativo" class="form-select @error('prod_ativo') is-invalid @enderror" required>
                            <option value="">{{ __('Selecione...') }}</option>
                            <option value="1" {{ old('prod_ativo') == 1 ? 'selected' : '' }}>{{ __('Ativo') }}</option>
                            <option value="0" {{ old('prod_ativo') === '0' ? 'selected' : '' }}>{{ __('Inativo') }}</option>
                        </select>
                        @error('prod_ativo')
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
        <h5 class="card-title">{{ __('Lista de Produtos') }}</h5>
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
                    data-url="{{ route('cadastros::produtos.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='prod_id'>
                                #
                            </th>
                            <th data-field='prod_codigo'>
                                {{ $model->getAttributeLabel('prod_codigo') }}
                            </th>
                            <th data-field='prod_nome'>
                                {{ $model->getAttributeLabel('prod_nome') }}
                            </th>
                            <th data-field='prod_tempo_estimado' data-formatter="App.segundosParaTime">
                                {{ $model->getAttributeLabel('prod_tempo_estimado') }}
                            </th>
                            <th data-field='prod_ativo' data-formatter="App.tipoMensagem">
                                {{ $model->getAttributeLabel('prod_ativo') }}
                            </th>
                            <th data-field='created_at'>
                                {{ $model->getAttributeLabel('created_at') }}
                            </th>
                            @canany(['Editar Produtos', 'Excluir Produtos'])
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
        let id = row['prod_id'];

        let urlEdit = "{{ route('cadastros::produtos.show', ['produto' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('cadastros::produtos.destroy', ['produto' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar Produtos')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarProd_'+ id +'" data-action="modal-editar-produto" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan

        @can('Excluir Produtos')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteProd_'+ id +'" data-action="excluir-produto" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
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
            form: 'form[name="editProduto"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirProduto(action) {
        App.confirm({
            title: "Excluir produto",
            message: "Deseja realmente excluir este produto?",
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
            case "modal-editar-produto":
                openEdit(action);
            break;

            case "editar-produto":
                editar(action);
            break;

            case "excluir-produto":
                excluirProduto(action);
            break;
        }
    });
</script>
@endpush
