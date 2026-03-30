@extends('layouts.default')

@section('page-title', 'Produção Diária')

@section('content')
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h5>Relatório de Produção Diária</h5>
            <p class="mb-0">Filtre por intervalo de datas e exporte em PDF ou Excel.</p>
        </div>
        <div>
            <a href="{{ route('relatorios::producao.diaria', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'pdf']) }}" class="btn btn-outline-secondary me-2">PDF</a>
            <a href="{{ route('relatorios::producao.diaria', ['start_date' => $dataInicio->format('Y-m-d'), 'end_date' => $dataFim->format('Y-m-d'), 'export' => 'excel']) }}" class="btn btn-outline-secondary">Excel</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('relatorios::producao.diaria') }}" method="GET" class="row gy-3 gx-3 align-items-end">
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

<div class="row mb-3">
    <div class="col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($quantidadeTotal, 0, ',', '.') }}</h3>
                <p>Total produzido</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $tempoTotal ? gmdate('H:i:s', $tempoTotal) : '00:00:00' }}</h3>
                <p>Tempo total registrado</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Funcionário</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Tempo gasto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $row)
                        <tr>
                            <td>{{ $row->produ_data->format('d/m/Y') }}</td>
                            <td>{{ $row->produ_hora }}</td>
                            <td>{{ $row->funcionario_nome }}</td>
                            <td>{{ $row->produto_nome }}</td>
                            <td>{{ $row->produ_quantidade }}</td>
                            <td>{{ $row->produ_tempo_gasto ? gmdate('H:i:s', $row->produ_tempo_gasto) : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum registro encontrado para este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
