@extends('layouts.default')

@section('page-title', 'Relatórios')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Relatórios de Produção</h5>
            </div>
            <div class="card-body">
                <p>Use este módulo para ver dados de produção, desempenho de funcionários e projeções.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Produção diária</h5>
                <p>Veja todos os registros de produção por data e faça exportação em PDF ou Excel.</p>
                <a href="{{ route('relatorios::producao.diaria') }}" class="btn btn-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Produtividade por funcionário</h5>
                <p>Compare eficiência, tempo médio por peça e peças por hora por funcionário.</p>
                <a href="{{ route('relatorios::produtividade.funcionario') }}" class="btn btn-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Produção por produto</h5>
                <p>Veja quais produtos são mais fabricados e qual o tempo médio gasto por peça.</p>
                <a href="{{ route('relatorios::producao.produto') }}" class="btn btn-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Comparativo de períodos</h5>
                <p>Compare semana atual com anterior e mês atual com anterior.</p>
                <a href="{{ route('relatorios::comparativo') }}" class="btn btn-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Projeção de produção</h5>
                <p>Veja a projeção do mês com base na média diária atual.</p>
                <a href="{{ route('relatorios::projecao') }}" class="btn btn-primary">Abrir relatório</a>
            </div>
        </div>
    </div>
</div>
@endsection
