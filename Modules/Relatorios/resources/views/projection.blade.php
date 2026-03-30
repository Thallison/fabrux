@extends('layouts.default')

@section('page-title', 'Projeção de Produção')

@section('content')
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h5>Relatório de Projeção</h5>
            <p class="mb-0">Projeção de produção para o mês com base na média diária atual.</p>
        </div>
        <div>
            <a href="{{ route('relatorios::projecao', ['export' => 'pdf']) }}" class="btn btn-outline-secondary me-2">PDF</a>
            <a href="{{ route('relatorios::projecao', ['export' => 'excel']) }}" class="btn btn-outline-secondary">Excel</a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ number_format($totalMes, 0, ',', '.') }}</h3>
                <p>Total acumulado</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($mediaDiaria, 2, ',', '.') }}</h3>
                <p>Média diária</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $diasRestantes }}</h3>
                <p>Dias restantes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($projecao, 0, ',', '.') }}</h3>
                <p>Projeção final</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Melhores funcionários no mês</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($melhoresFuncionarios as $funcionario)
                                <tr>
                                    <td>{{ $funcionario->funcionario_nome }}</td>
                                    <td>{{ $funcionario->quantidade_total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Sem registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Principais produtos no mês</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($melhoresProdutos as $produto)
                                <tr>
                                    <td>{{ $produto->produto_nome }}</td>
                                    <td>{{ $produto->quantidade_total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Sem registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
