@extends('layouts.default')

@section('page-title', 'Dashboard de Produção')

@section('content')

<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-end">
        <a href="{{ route('producao::producoes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar para Produção
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ number_format($totalToday, 0, ',', '.') }}</h3>
                <p>Total produzido hoje</p>
            </div>
            <div class="icon">
                <i class="bi bi-bar-chart-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($todayAveragePerHour, 2, ',', '.') }}</h3>
                <p>Média por hora</p>
            </div>
            <div class="icon">
                <i class="bi bi-clock-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $topEmployeesToday->first() ? $topEmployeesToday->first()->funcionario_nome : 'N/A' }}</h3>
                <p>Melhor funcionário hoje</p>
            </div>
            <div class="icon">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ count($alerts) }}</h3>
                <p>Alertas</p>
            </div>
            <div class="icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Produção nos últimos 7 dias</h5>
            </div>
            <div class="card-body">
                <canvas id="chartDaily"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Ranking de hoje</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($topEmployeesToday as $employee)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $employee->funcionario_nome }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $employee->total_quantity }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">Sem registros para hoje.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Eficiência de funcionários</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Produzido</th>
                                <th>Horas</th>
                                <th>Peças/h</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($efficiencyRanking as $item)
                                <tr>
                                    <td>{{ $item->funcionario_nome }}</td>
                                    <td>{{ $item->total_quantity }}</td>
                                    <td>{{ $item->production_per_hour }}</td>
                                    <td>{{ $item->avg_seconds ? gmdate('H:i:s', $item->avg_seconds) : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Sem dados de tempo registrado.</td>
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
                <h5 class="card-title">Produção por hora</h5>
            </div>
            <div class="card-body">
                <canvas id="chartHourly"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Projeção do mês</h5>
            </div>
            <div class="card-body">
                <p><strong>Total acumulado:</strong> {{ number_format($totalMonth, 0, ',', '.') }}</p>
                <p><strong>Média diária:</strong> {{ number_format($averageDailyMonth, 2, ',', '.') }}</p>
                <p><strong>Dias restantes:</strong> {{ $daysRemaining }}</p>
                <p><strong>Previsão de fim de mês:</strong> {{ number_format($projectedMonth, 0, ',', '.') }}</p>
                <div class="progress mb-3" style="height: 1rem;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $monthProgress }}%;" aria-valuenow="{{ $monthProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0"><small>A projeção considera a média diária atual.</small></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Principais produtos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Tempo médio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productStats as $product)
                                <tr>
                                    <td>{{ $product->prod_nome }}</td>
                                    <td>{{ $product->total_quantity }}</td>
                                    <td>{{ $product->avg_seconds ? gmdate('H:i:s', $product->avg_seconds) : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Sem registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Produção mensal</h5>
            </div>
            <div class="card-body">
                <canvas id="chartMonthly"></canvas>
            </div>
        </div>
    </div>
</div>

@if(count($alerts))
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">Alertas</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach($alerts as $alert)
                        <li>{{ $alert }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dailyCtx = document.getElementById('chartDaily');
        if (dailyCtx) {
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: @json($dailyProductionLabels),
                    datasets: [{
                        label: 'Produção',
                        data: @json($dailyProductionData),
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.15)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        }

        const hourlyCtx = document.getElementById('chartHourly');
        if (hourlyCtx) {
            new Chart(hourlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($hourlyProductionLabels),
                    datasets: [{
                        label: 'Quantidade',
                        data: @json($hourlyProductionData),
                        backgroundColor: 'rgba(40, 167, 69, 0.75)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        }

        const monthlyCtx = document.getElementById('chartMonthly');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyProductionLabels),
                    datasets: [{
                        label: 'Produção',
                        data: @json($monthlyProductionData),
                        backgroundColor: 'rgba(255, 193, 7, 0.75)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        }
    });
</script>
@endpush
