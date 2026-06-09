@extends('layouts.default')

@section('page-title', 'Visualizar Cliente')

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">{{ $dados->cli_nome }}</h5>
    </div>

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_codigo') }}</p>
                <h6>{{ $dados->cli_codigo }}</h6>
            </div>

            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_tipo') }}</p>
                <h6>
                    @if($dados->cli_tipo === 'F')
                        <span class="badge bg-info">{{ __('Pessoa Física') }}</span>
                    @else
                        <span class="badge bg-warning">{{ __('Pessoa Jurídica') }}</span>
                    @endif
                </h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_nome') }}</p>
                <h6>{{ $dados->cli_nome }}</h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_cpf_cnpj') }}</p>
                <h6>{{ $dados->cli_cpf_cnpj }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_ie') }}</p>
                <h6>{{ $dados->cli_ie ?? '-' }}</h6>
            </div>

            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_im') }}</p>
                <h6>{{ $dados->cli_im ?? '-' }}</h6>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-8">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_logradouro') }}</p>
                <h6>{{ $dados->cli_logradouro }}, {{ $dados->cli_numero }}</h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_complemento') }}</p>
                <h6>{{ $dados->cli_complemento ?? '-' }}</h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_bairro') }}</p>
                <h6>{{ $dados->cli_bairro }}</h6>
            </div>

            <div class="col-md-6">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_cidade') }} / {{ $model->getAttributeLabel('cli_estado') }} / {{ $model->getAttributeLabel('cli_cep') }}</p>
                <h6>{{ $dados->cli_cidade }} / {{ $dados->cli_estado }} / {{ $dados->cli_cep }}</h6>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_telefone') }}</p>
                <h6>{{ $dados->cli_telefone ?? '-' }}</h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_celular') }}</p>
                <h6>{{ $dados->cli_celular ?? '-' }}</h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_email') }}</p>
                <h6>
                    <a href="mailto:{{ $dados->cli_email }}">{{ $dados->cli_email }}</a>
                </h6>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_nao_contribuinte') }}</p>
                <h6>
                    @if($dados->cli_nao_contribuinte)
                        <span class="badge bg-success">{{ __('Sim') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Não') }}</span>
                    @endif
                </h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_substituto_tributario_iss') }}</p>
                <h6>
                    @if($dados->cli_substituto_tributario_iss)
                        <span class="badge bg-success">{{ __('Sim') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Não') }}</span>
                    @endif
                </h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_nao_calcula_diferimento_icms') }}</p>
                <h6>
                    @if($dados->cli_nao_calcula_diferimento_icms)
                        <span class="badge bg-success">{{ __('Sim') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Não') }}</span>
                    @endif
                </h6>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_apura_icms') }}</p>
                <h6>
                    @if($dados->cli_apura_icms)
                        <span class="badge bg-success">{{ __('Sim') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Não') }}</span>
                    @endif
                </h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_aliquota_icms_diferenciada_contribuinte') }}</p>
                <h6>
                    @if($dados->cli_aliquota_icms_diferenciada_contribuinte)
                        <span class="badge bg-success">{{ __('Sim') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Não') }}</span>
                    @endif
                </h6>
            </div>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('cli_ativo') }}</p>
                <h6>
                    @if($dados->cli_ativo)
                        <span class="badge bg-success">{{ __('Ativo') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('Inativo') }}</span>
                    @endif
                </h6>
            </div>

            <div class="col-md-4">
                <p class="text-muted mb-0">{{ $model->getAttributeLabel('created_at') }}</p>
                <h6>{{ $dados->created_at }}</h6>
            </div>
        </div>
    </div>

    <div class="card-footer text-end">
        @can('Editar Clientes')
            <a href="{{ route('cadastros::clientes.edit', $dados->cli_id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> {{ __('Editar') }}
            </a>
        @endcan
        <a href="{{ route('cadastros::clientes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('Voltar') }}
        </a>
    </div>
</div>

@endsection
