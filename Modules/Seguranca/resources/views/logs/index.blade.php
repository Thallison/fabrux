@extends('layouts.default')

@section('page-title', 'Logs')

@section('content')

<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Logs') }}</h5>
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
                    data-url="{{ route('seguranca::logs.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='log_id' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_id') }}
                            </th>
                            <th data-field='usr_id' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('usr_id') }}
                            </th>
                            <th data-field='log_controller' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_controller') }}
                            </th>
                            <th data-field='log_action' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_action') }}
                            </th>
                            <th data-field='log_nome_rota' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_nome_rota') }}
                            </th>
                            <th data-field='log_dt_inclusao' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_dt_inclusao') }}
                            </th>
                            <th data-field='log_tipo' data-sortable="true" data-formatter="tipoMensagem" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_tipo') }}
                            </th>
                            <th data-field='log_msg' data-sortable="true" data-filter-control="input">
                                {{ $model->getAttributeLabel('log_msg') }}
                            </th>
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
    function tipoMensagem (value, row, index)
    {
        let msg;
        switch (value) {
            case 'emergency':
                msg = '<span class="badge bg-orange">Emergency</span>';
                break;
            case 'alert':
                msg = '<span class="badge bg-primary">Alert</span>';
                break;
            case 'critical':
                msg = '<span class="badge bg-danger">Critical</span>';
                break;
            case 'error':
                msg = '<span class="badge bg-danger">Error</span>';
                break;
            case 'warning':
                msg = '<span class="badge bg-warning">Warning</span>';
                break;
            case 'notice':
                msg = '<span class="badge bg-info">Notice</span>';
                break;
            case 'info':
                msg = '<span class="badge bg-info">Info</span>';
                break;
            case 'debug':
                msg = '<span class="badge bg-slate">Debug</span>';
                break;
            default:
                msg = '<span class="badge"> </span>';
                break;
        }

        return msg;
    }
</script>
@endpush