@extends('layouts.default')

@section('page-title', 'Setores')

@section('content')

@can('Cadastrar Setores')
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Setores') }}</h5>
    </div>
    <form action="{{ route('cadastros::setores.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('set_nome') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('set_nome') is-invalid @enderror" type="text" name="set_nome" required placeholder="{{ $model->getAttributeLabel('set_nome') }}" value="{{ old('set_nome') }}" />
                        @error('set_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('set_codigo') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('set_codigo') is-invalid @enderror" type="text" name="set_codigo" required placeholder="{{ $model->getAttributeLabel('set_codigo') }}" value="{{ old('set_codigo') }}" />
                        @error('set_codigo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('set_ativo') }} <span class="text-danger">*</span></label>
                        <select name="set_ativo" id="set_ativo_create" class="form-select" data-tom-select="true" data-tom-select-placeholder="Selecione um status" required @error('set_ativo') is-invalid @enderror>
                            <option value="">{{ __('Selecione...') }}</option>
                            <option value="1" {{ old('set_ativo') == 1 ? 'selected' : '' }}>
                                {{ __('Ativo') }}
                            </option>
                            <option value="0" {{ old('set_ativo') === 0 ? 'selected' : '' }}>
                                {{ __('Inativo') }}
                            </option>
                        </select>
                        @error('set_ativo')
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

<div class="card card-default">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Setores') }}</h5>
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
                data-url="{{ route('cadastros::setores.index') }}"
                data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}">
                <thead>
                    <tr>
                        <th data-field='set_id'>
                            #
                        </th>
                        <th data-field='set_codigo'>
                            {{ $model->getAttributeLabel('set_codigo') }}
                        </th>
                        <th data-field='set_nome'>
                            {{ $model->getAttributeLabel('set_nome') }}
                        </th>
                        <th data-field='set_ativo' data-formatter="App.tipoMensagem">
                            {{ $model->getAttributeLabel('set_ativo') }}
                        </th>
                        <th data-field='created_at'>
                            {{ $model->getAttributeLabel('created_at') }}
                        </th>
                        @canany(['Editar Setores', 'Excluir Setores'])
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
    function TableActions(value, row, index) {
        let editar = excluir = '';
        let id = row['set_id'];

        let urlEdit = "{{ route('cadastros::setores.show', ['setor' => ':id']) }}";
        urlEdit = urlEdit.replace(':id', id);

        let urlDel = "{{ route('cadastros::setores.destroy', ['setor' => ':id']) }}";
        urlDel = urlDel.replace(':id', id);

        @can('Editar Setores')
        editar = '<a class="btn btn-outline-info btn-sm"'
            +'id="editarSet_'+ id +'" data-action="modal-editar-setor" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
            +'<i class="bi bi-pencil-square"></i>'
            +'</a> ';
        @endcan

        @can('Excluir Setores')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
            +'data-method="DELETE"'
            +'id="deleteSet_'+ id +'" data-action="excluir-setor" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
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
        App.modal(action.dataset.url);
    }

    function editar(action) {
        App.submitForm({
            form: 'form[name="editSetor"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirSetor(action) {
        App.confirm({
            title: 'Excluir setor',
            message: 'Deseja realmente excluir este setor?',
            url: action.dataset.url,
            table: 'gridTable'
        });
    }

    document.addEventListener('click', function(e) {
        const action = e.target.closest('[data-action]');

        if (!action) {
            return;
        }

        e.preventDefault();

        const tipo = action.dataset.action;

        switch (tipo) {
            case 'modal-editar-setor':
                openEdit(action);
            break;

            case 'editar-setor':
                editar(action);
            break;

            case 'excluir-setor':
                excluirSetor(action);
            break;
        }
    });
</script>
@endpush
