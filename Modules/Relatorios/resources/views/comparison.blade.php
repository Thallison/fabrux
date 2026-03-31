@extends('layouts.default')

@section('page-title', 'Comparativo de Produção')

@section('content')
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

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Semana</h6><br>
                <p class="mb-1">Atual: <strong>{{ number_format($semanaAtual, 0, ',', '.') }}</strong></p>
                <p class="mb-0">Anterior: <strong>{{ number_format($semanaAnterior, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">Mês</h6><br>
                <p class="mb-1">Atual: <strong>{{ number_format($mesAtual, 0, ',', '.') }}</strong></p>
                <p class="mb-0">Anterior: <strong>{{ number_format($mesAnterior, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <canvas id="chartComparison"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
