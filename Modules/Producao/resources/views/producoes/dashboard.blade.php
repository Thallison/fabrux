@extends('layouts.default')

@section('page-title', 'Dashboard de Produção')

@section('content')

<div class="fabrux-production-dashboard">
<div class="card fabrux-dashboard-intro mb-4">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <span class="fabrux-dashboard-eyebrow">Visão operacional</span>
                <h4 class="mb-2">Acompanhe ritmo, eficiência e projeção da produção em um único painel.</h4>
                <p class="mb-0 text-muted">Os indicadores abaixo consolidam o desempenho diário, apontam alertas e ajudam a antecipar o fechamento do mês com mais clareza.</p>
            </div>
            <div class="col-lg-4">
                <div class="fabrux-dashboard-highlight">
                    <span class="fabrux-dashboard-highlight-label">Fechamento projetado</span>
                    <strong>{{ number_format($projectedMonth, 0, ',', '.') }}</strong>
                    <small>{{ number_format($monthProgress, 0, ',', '.') }}% do mês já percorrido</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-primary">
            <div class="inner">
                <h3>{{ number_format($totalToday, 0, ',', '.') }}</h3>
                <p>Total produzido hoje</p>
                <span class="fabrux-kpi-meta">volume consolidado do turno</span>
            </div>
            <div class="icon">
                <i class="bi bi-bar-chart-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-success">
            <div class="inner">
                <h3>{{ number_format($todayAveragePerHour, 2, ',', '.') }}</h3>
                <p>Média por hora</p>
                <span class="fabrux-kpi-meta">cadência operacional atual</span>
            </div>
            <div class="icon">
                <i class="bi bi-clock-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-warning">
            <div class="inner">
                <h3>{{ $topEmployeesToday->first() ? $topEmployeesToday->first()->funcionario_nome : 'N/A' }}</h3>
                <p>Melhor funcionário hoje</p>
                <span class="fabrux-kpi-meta">liderança do ranking diário</span>
            </div>
            <div class="icon">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-danger">
            <div class="inner">
                <h3>{{ count($alerts) }}</h3>
                <p>Alertas</p>
                <span class="fabrux-kpi-meta">pontos que exigem atenção</span>
            </div>
            <div class="icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card h-100 fabrux-dashboard-chart-card">
            <div class="card-header">
                <h5 class="card-title mb-1">Produção nos últimos 7 dias</h5>
                <p class="fabrux-card-subtitle mb-0">Evolução recente para leitura rápida de tendência.</p>
            </div>
            <div class="card-body">
                <canvas id="chartDaily"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-1">Ranking de hoje</h5>
                <p class="fabrux-card-subtitle mb-0">Quem mais produziu no período atual.</p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush fabrux-ranking-list">
                    @forelse($topEmployeesToday as $employee)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="fabrux-ranking-position">{{ $loop->iteration }}</span>
                                <span>{{ $employee->funcionario_nome }}</span>
                            </div>
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
                <h5 class="card-title mb-1">Eficiência de funcionários</h5>
                <p class="fabrux-card-subtitle mb-0">Comparativo entre volume, horas e produtividade.</p>
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
                <h5 class="card-title mb-1">Produção por hora</h5>
                <p class="fabrux-card-subtitle mb-0">Distribuição do volume ao longo do expediente.</p>
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
                <h5 class="card-title mb-1">Projeção do mês</h5>
                <p class="fabrux-card-subtitle mb-0">Estimativa baseada na média diária atual.</p>
            </div>
            <div class="card-body">
                <div class="fabrux-projection-list mb-3">
                    <div><span>Total acumulado</span><strong>{{ number_format($totalMonth, 0, ',', '.') }}</strong></div>
                    <div><span>Média diária</span><strong>{{ number_format($averageDailyMonth, 2, ',', '.') }}</strong></div>
                    <div><span>Dias restantes</span><strong>{{ number_format($daysRemaining, 0, ',', '.') }}</strong></div>
                    <div><span>Previsão de fim de mês</span><strong>{{ number_format($projectedMonth, 0, ',', '.') }}</strong></div>
                </div>
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
                <h5 class="card-title mb-1">Principais produtos</h5>
                <p class="fabrux-card-subtitle mb-0">Itens com maior volume e melhor noção de tempo médio.</p>
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
        <div class="card fabrux-dashboard-chart-card">
            <div class="card-header">
                <h5 class="card-title mb-1">Produção mensal</h5>
                <p class="fabrux-card-subtitle mb-0">Histórico consolidado para análise de sazonalidade.</p>
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
        <div class="card border-danger fabrux-alert-card">
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

</div>

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
                        borderColor: '#0c6ca8',
                        backgroundColor: 'rgba(12, 108, 168, 0.2)',
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
                        backgroundColor: 'rgba(38, 166, 154, 0.82)'
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
                        backgroundColor: 'rgba(12, 108, 168, 0.72)'
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
