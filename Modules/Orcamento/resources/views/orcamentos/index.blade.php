@extends('layouts.default')
@section('page-title', 'Orçamentos')
@section('content')
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(145deg, #f8fafc, #eef5ff);">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 py-4">
        <div>
            <h3 class="mb-1">Orçamentos</h3>
            <p class="text-muted mb-0">Monte propostas com desconto, PDF profissional e envio rápido para seus clientes.</p>
        </div>
        <div class="d-flex flex-wrap gap-2 ms-lg-auto justify-content-lg-end">
            @can('Configurar Cabecalho Orcamentos')
            <a href="{{ route('orcamento::orcamentos.header-config') }}" class="btn btn-outline-secondary">
                <i class="bi bi-sliders"></i> Configurar Cabecalho PDF
            </a>
            @endcan

            @can('Cadastrar Orcamentos')
            <a href="{{ route('orcamento::orcamentos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Orçamento
            </a>
            @endcan
        </div>
    </div>
</div>

<div class="card card-default">
    <div class="card-body">
        <form method="GET" action="{{ route('orcamento::orcamentos.index') }}" class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <label class="form-label mb-1">Busca</label>
                <input
                    type="text"
                    name="busca"
                    value="{{ $busca }}"
                    class="form-control"
                    placeholder="Buscar por número do orçamento ou nome do cliente"
                >
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label mb-1">Cliente</label>
                <select name="cli_id" id="cli_id_filtro" class="form-select" data-tom-select="true" data-tom-select-placeholder="Todos os clientes">
                    <option value="">Todos os clientes</option>
                    @foreach($clientesFiltro as $clienteFiltro)
                    <option value="{{ $clienteFiltro->cli_id }}" @selected(((int) ($filtros['cli_id'] ?? 0)) === (int) $clienteFiltro->cli_id)>{{ $clienteFiltro->cli_nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label mb-1">Status</label>
                <select name="status" id="status_filtro" class="form-select" data-tom-select="true" data-tom-select-placeholder="Todos os status">
                    <option value="">Todos os status</option>
                    @foreach($statusOpcoes as $statusOpcao)
                    <option value="{{ $statusOpcao }}" @selected(($filtros['status'] ?? '') === $statusOpcao)>{{ $statusOpcao }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-2 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-outline-primary w-100">Filtrar</button>
                <a href="{{ route('orcamento::orcamentos.index') }}" class="btn btn-outline-secondary w-100">Limpar</a>
            </div>

            <div class="col-12 col-lg-6">
                <div class="border rounded-3 p-3 h-100" style="background-color: #f8fafc;">
                    <div class="small fw-semibold text-muted mb-2">Período de Criação</div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label mb-1">De</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ $filtros['data_inicio'] ?? '' }}" title="Data inicial de criação" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-1">Até</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ $filtros['data_fim'] ?? '' }}" title="Data final de criação" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="border rounded-3 p-3 h-100" style="background-color: #f8fafc;">
                    <div class="small fw-semibold text-muted mb-2">Período de Validade</div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label mb-1">De</label>
                            <input type="date" name="data_validade_inicio" class="form-control" value="{{ $filtros['data_validade_inicio'] ?? '' }}" title="Data inicial de validade" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-1">Até</label>
                            <input type="date" name="data_validade_fim" class="form-control" value="{{ $filtros['data_validade_fim'] ?? '' }}" title="Data final de validade" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Criação</th>
                        <th>Validade</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orcamentos as $orcamento)
                    <tr>
                        <td class="fw-semibold">{{ $orcamento->orc_numero }}</td>
                        <td>{{ $orcamento->cliente?->cli_nome ?? '-' }}</td>
                        <td>{{ optional($orcamento->orc_data_emissao)->format('d/m/Y') }}</td>
                        <td>{{ optional($orcamento->orc_data_validade)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $badgeStatus = match ($orcamento->orc_status) {
                                    'Aprovado' => 'bg-success',
                                    'Rejeitado' => 'bg-danger',
                                    'Expirado' => 'bg-warning text-dark',
                                    'Enviado' => 'bg-info text-dark',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeStatus }}">{{ $orcamento->orc_status }}</span>
                        </td>
                        <td class="text-end">R$ {{ number_format((float) $orcamento->orc_total, 2, ',', '.') }}</td>
                        <td class="text-end">
                            @can('Visualizar Orcamentos')
                            <a href="{{ route('orcamento::orcamentos.show', $orcamento->orc_id) }}" class="btn btn-sm btn-outline-primary" title="Abrir">
                                <i class="bi bi-eye"></i>
                            </a>
                            @can('Editar Orcamentos')
                            <a href="{{ route('orcamento::orcamentos.edit', $orcamento->orc_id) }}" class="btn btn-sm btn-outline-info" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @endcan
                            @can('Duplicar Orcamentos')
                            <form action="{{ route('orcamento::orcamentos.duplicate', $orcamento->orc_id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Duplicar">
                                    <i class="bi bi-files"></i>
                                </button>
                            </form>
                            @endcan
                            <a href="{{ route('orcamento::orcamentos.preview-pdf', $orcamento->orc_id) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="Visualizar PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="{{ route('orcamento::orcamentos.send-whatsapp', $orcamento->orc_id) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Enviar WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            @endcan

                            @can('Excluir Orcamentos')
                            <form action="{{ route('orcamento::orcamentos.destroy', $orcamento->orc_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este orçamento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhum orçamento encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $orcamentos->links() }}
        </div>
    </div>
</div>
@endsection


