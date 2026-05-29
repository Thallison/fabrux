@extends('layouts.default')

@section('page-title', 'Produtividade por Funcionário')

@section('content')
<div class="fabrux-production-dashboard">
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h5>Relatório de Produtividade por Funcionário</h5>
            <p class="mb-0">Veja quem entrega mais peças e quem precisa de atenção.</p>
        </div>
        <div>
            <a href="{{ route('relatorios::produtividade.funcionario', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'pdf']) }}" class="btn btn-outline-secondary me-2">PDF</a>
            <a href="{{ route('relatorios::produtividade.funcionario', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'excel']) }}" class="btn btn-outline-secondary">Excel</a>
        </div>
    </div>
</div>

<div class="card fabrux-dashboard-intro mb-4">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="fabrux-dashboard-eyebrow">Eficiência operacional</span>
            <h4 class="mb-2">Entenda quem entrega mais volume com melhor aproveitamento de tempo.</h4>
            <p class="mb-0 text-muted">Use o período selecionado para comparar quantidade, tempo total e produtividade por hora entre os funcionários.</p>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('relatorios::produtividade.funcionario') }}" method="GET" class="row gy-3 gx-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Data inicial</label>
                <input type="date" name="start_date" class="form-control" value="{{ $dataInicio->format('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label">Data final</label>
                <input type="date" name="end_date" class="form-control" value="{{ $dataFim->format('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="card fabrux-data-table-card">
    <div class="card-header">
        <h5 class="card-title mb-1">Desempenho por funcionário</h5>
        <p class="fabrux-card-subtitle mb-0">Volume, tempo acumulado e ritmo de produção por colaborador.</p>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Quantidade</th>
                        <th>Tempo total</th>
                        <th>Tempo médio/peça</th>
                        <th>Peças/h</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $registro)
                        <tr>
                            <td>{{ $registro->funcionario_nome }}</td>
                            <td>{{ $registro->quantidade_total }}</td>
                            <td>{{ $registro->tempo_total ? gmdate('H:i:s', $registro->tempo_total) : '-' }}</td>
                            <td>{{ $registro->tempo_medio_segundos ? gmdate('H:i:s', $registro->tempo_medio_segundos) : '-' }}</td>
                            <td>{{ $registro->pecas_por_hora }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Sem dados para este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
