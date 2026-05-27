@extends('layouts.default')

@section('page-title', 'Clientes')

@section('content')

<div class="card card-default">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Clientes') }}</h5>

        @can('Cadastrar Clientes')
        <div class="text-end header-elements ms-auto">
            <a href="{{ route('cadastros::clientes.create') }}" class="btn btn-info">
                <i class="bi bi-plus"></i> {{ __('Novo Cliente') }}
            </a>
        </div>
        @endcan
    </div>

    <div class="card-body">
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
                data-url="{{ route('cadastros::clientes.index') }}"
                data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}">
                <thead>
                    <tr>
                        <th data-field='cli_id'>
                            #
                        </th>
                        <th data-field='cli_codigo'>
                            {{ $model->getAttributeLabel('cli_codigo') }}
                        </th>
                        <th data-field='cli_nome'>
                            {{ $model->getAttributeLabel('cli_nome') }}
                        </th>
                        <th data-field='cli_tipo' data-formatter="App.tipoPessoaMensagem">
                            {{ $model->getAttributeLabel('cli_tipo') }}
                        </th>
                        <th data-field='cli_cpf_cnpj'>
                            {{ $model->getAttributeLabel('cli_cpf_cnpj') }}
                        </th>
                        <th data-field='cli_email'>
                            {{ $model->getAttributeLabel('cli_email') }}
                        </th>
                        <th data-field='cli_ativo' data-formatter="App.tipoMensagem">
                            {{ $model->getAttributeLabel('cli_ativo') }}
                        </th>
                        <th data-field='created_at'>
                            {{ $model->getAttributeLabel('created_at') }}
                        </th>
                        @canany(['Editar Clientes', 'Excluir Clientes'])
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

@endsection

@push('scripts')
<script>
    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = visualizar = excluir = '';
        let id = row['cli_id'];

        let urlShow = "{{ route('cadastros::clientes.show', ['cliente' => ':id']) }}";
        urlShow = urlShow.replace(":id", id);

        let urlEdit = "{{ route('cadastros::clientes.edit', ['cliente' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('cadastros::clientes.destroy', ['cliente' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        visualizar = '<a class="btn btn-outline-primary btn-sm" href="' + urlShow + '" title="{{ __('Visualizar') }}" >'
                    +'<i class="bi bi-eye"></i>'
                    +'</a> ';

        @can('Editar Clientes')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarCli_'+ id +'" href="' + urlEdit + '" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan

        @can('Excluir Clientes')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteCli_'+ id +'" data-action="excluir-cliente" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
                +'<i class="bi bi-trash3-fill"></i>'
                +'</a>';
        @endcan
        
        return [
            '<div class="list-icons">',
            visualizar,
            editar,
            excluir,
            '</div>'
        ].join('');

    }

    function excluirCliente(action) {
        App.confirm({
            title: "Excluir cliente",
            message: "Deseja realmente excluir este cliente?",
            url: action.dataset.url,
            table: 'gridTable'
        });
    }

    document.addEventListener("click", function(e){
        const action = e.target.closest("[data-action]");

        if(!action) return;
        e.preventDefault();

        const tipo = action.dataset.action;

        switch(tipo){
            case "excluir-cliente":
                excluirCliente(action);
            break;
        }
    });
</script>
@endpush
