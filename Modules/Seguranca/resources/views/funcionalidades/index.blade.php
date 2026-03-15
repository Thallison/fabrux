@extends('layouts.default')

@section('page-title', 'Funcionalidades')

@section('content')

@if (!$modulos))
    <div class="alert alert-info alert-styled-left alert-dismissible alert-important">
        <span class="font-weight-semibold">Aviso</span>
            Para cadastrar uma funcionalidade é necessário ter pelo menos um modulo cadastrado,
        <a href="{{ route('seguranca::modulos.index') }}" class="alert-link">Clique aqui para cadastrar um modulo.</a>
    </div>
@else

<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Funcionalidades') }}</h5>
        <div class="text-end">
            <a href="{{ route('seguranca::funcionalidades.create') }}" class="btn btn-info"><i class="bi bi-plus"></i> {{ __('Cadastrar Funcionalidade') }}</a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
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
                    data-url="{{ route('seguranca::funcionalidades.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='func_label' data-sortable="true">
                                {{ $model->getAttributeLabel('func_label') }}
                            </th>
                            <th data-field='mod_nome' data-sortable="true">
                                {{ $model->getAttributeLabel('mod_id') }}
                            </th>
                            <th data-field='func_controller' data-sortable="true">
                                {{ $model->getAttributeLabel('func_controller') }}
                            </th>
                            <th data-field='func_pai_label' data-sortable="true">
                                {{ $model->getAttributeLabel('func_id_pai') }}
                            </th>
                            <th data-field='func_icon'>
                                {{ $model->getAttributeLabel('func_icon') }}
                            </th>
                            <th data-field='func_tipo' data-sortable="true">
                                {{ $model->getAttributeLabel('func_tipo') }}
                            </th>
                            <th data-field='func_rota_padrao' data-sortable="true">
                                {{ $model->getAttributeLabel('func_rota_padrao') }}
                            </th>
                            <th data-field='func_acesso_menu' data-sortable="true"
                                data-formatter="App.formatters.boolean" >
                                {{ $model->getAttributeLabel('func_acesso_menu') }}
                            </th>
                            <th data-formatter="TableActions" class="w-10">
                                {{ __('Ações') }}
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = excluir = '';
        let id = row['mod_id'];

        let urlEdit = "{{ route('seguranca::modulos.show', ['modulo' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('seguranca::modulos.destroy', ['modulo' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarMod_'+ id +'" data-action="modal-editar-modulo" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteMod_'+ id +'" data-action="excluir-modulo" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
                +'<i class="bi bi-trash3-fill"></i>'
                +'</a>';
        
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
        const form = document.querySelector('form[name="editModulo"]');
        const formData = new FormData(form);

        /*Submeer formulario do modal*/
        App.submitForm({
            form: 'form[name="editModulo"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirModulo(action) {
        App.confirm({
            title: "Excluir modulo",
            message: "Deseja realmente excluir este modulo?",
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
            case "modal-editar-modulo":
                openEdit(action);
            break;

            case "editar-modulo":
                editar(action);
            break;

            case "excluir-modulo":
                excluirModulo(action);
            break;
        }
    });
</script>
@endpush