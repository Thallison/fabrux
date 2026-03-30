@extends('layouts.default')

@section('page-title', 'Produção por Produto')

@section('content')
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h5>Relatório de Produção por Produto</h5>
            <p class="mb-0">Identifique quais produtos consomem mais tempo e quais são mais produzidos.</p>
        </div>
        <div>
            <a href="{{ route('relatorios::producao.produto', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'pdf']) }}" class="btn btn-outline-secondary me-2">PDF</a>
            <a href="{{ route('relatorios::producao.produto', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'excel']) }}" class="btn btn-outline-secondary">Excel</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('relatorios::producao.produto') }}" method="GET" class="row gy-3 gx-3 align-items-end">
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

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Tempo total</th>
                        <th>Tempo médio/peça</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $registro)
                        <tr>
                            <td>{{ $registro->produto_nome }}</td>
                            <td>{{ $registro->quantidade_total }}</td>
                            <td>{{ $registro->tempo_total ? gmdate('H:i:s', $registro->tempo_total) : '-' }}</td>
                            <td>{{ $registro->tempo_medio_segundos ? gmdate('H:i:s', $registro->tempo_medio_segundos) : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Sem dados para este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
