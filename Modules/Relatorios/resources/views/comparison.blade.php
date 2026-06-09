@extends('layouts.default')

@section('page-title', 'Comparativo de Produção')

@section('content')
<div class="fabrux-production-dashboard">
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h5>Relatório Comparativo</h5>
            <p class="mb-0">Compare o desempenho atual com o período anterior.</p>
        </div>
        <div>
            <a href="{{ route('relatorios::comparativo', ['export' => 'pdf']) }}" class="btn btn-outline-secondary me-2">PDF</a>
            <a href="{{ route('relatorios::comparativo', ['export' => 'excel']) }}" class="btn btn-outline-secondary">Excel</a>
        </div>
    </div>
</div>

<div class="card fabrux-dashboard-intro mb-4">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="fabrux-dashboard-eyebrow">Comparativo temporal</span>
            <h4 class="mb-2">Compare a produção atual com o período anterior e identifique tendência de crescimento ou retração.</h4>
            <p class="mb-0 text-muted">O painel consolida semana, mês e o comportamento diário recente em uma leitura única.</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-primary h-100">
            <div class="inner">
                <h3>Semana</h3>
                <p>Comparativo semanal</p>
                <div class="fabrux-comparison-metrics mt-3">
                    <div><span>Atual</span><strong>{{ number_format($semanaAtual, 0, ',', '.') }}</strong></div>
                    <div><span>Anterior</span><strong>{{ number_format($semanaAnterior, 0, ',', '.') }}</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box fabrux-kpi-box fabrux-kpi-box-info h-100">
            <div class="inner">
                <h3>Mês</h3>
                <p>Comparativo mensal</p>
                <div class="fabrux-comparison-metrics mt-3">
                    <div><span>Atual</span><strong>{{ number_format($mesAtual, 0, ',', '.') }}</strong></div>
                    <div><span>Anterior</span><strong>{{ number_format($mesAnterior, 0, ',', '.') }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card fabrux-dashboard-chart-card">
    <div class="card-header">
        <h5 class="card-title mb-1">Produção nos últimos 14 dias</h5>
        <p class="fabrux-card-subtitle mb-0">Leitura rápida da tendência recente para comparação com o histórico imediato.</p>
    </div>
    <div class="card-body">
        <canvas id="chartComparison"></canvas>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartComparison');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($rotulosDiarios),
                datasets: [{
                    label: 'Produção nos últimos 14 dias',
                    data: @json($valoresDiarios),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.15)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endpush
