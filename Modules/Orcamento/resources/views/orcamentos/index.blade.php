@extends('layouts.default')

@section('page-title', 'Orcamentos')

@section('content')
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(145deg, #f8fafc, #eef5ff);">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 py-4">
        <div>
            <h3 class="mb-1">Orcamentos</h3>
            <p class="text-muted mb-0">Monte propostas com desconto, PDF profissional e envio rapido para seus clientes.</p>
        </div>
        <div class="d-flex gap-2">
            @can('Configurar Cabecalho Orcamentos')
            <a href="{{ route('orcamento::orcamentos.header-config') }}" class="btn btn-outline-secondary">
                <i class="bi bi-sliders"></i> Configurar Cabecalho PDF
            </a>
            @endcan

            @can('Cadastrar Orcamentos')
            <a href="{{ route('orcamento::orcamentos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Orcamento
            </a>
            @endcan
        </div>
    </div>
</div>

<div class="card card-default">
    <div class="card-body">
        <form method="GET" action="{{ route('orcamento::orcamentos.index') }}" class="row g-2 mb-4">
            <div class="col-md-8">
                <input
                    type="text"
                    name="busca"
                    value="{{ $busca }}"
                    class="form-control"
                    placeholder="Buscar por numero do orcamento ou nome do cliente"
                >
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">Buscar</button>
                <a href="{{ route('orcamento::orcamentos.index') }}" class="btn btn-outline-secondary w-100">Limpar</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Criacao</th>
                        <th>Validade</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Acoes</th>
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
                            <span class="badge {{ $orcamento->orc_status === 'Enviado' ? 'bg-info' : 'bg-secondary' }}">
                                {{ $orcamento->orc_status }}
                            </span>
                        </td>
                        <td class="text-end">R$ {{ number_format((float) $orcamento->orc_total, 2, ',', '.') }}</td>
                        <td class="text-end">
                            @can('Visualizar Orcamentos')
                            <a href="{{ route('orcamento::orcamentos.show', $orcamento->orc_id) }}" class="btn btn-sm btn-outline-primary" title="Abrir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('orcamento::orcamentos.preview-pdf', $orcamento->orc_id) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="Visualizar PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            <a href="{{ route('orcamento::orcamentos.send-whatsapp', $orcamento->orc_id) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Enviar WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            @endcan

                            @can('Excluir Orcamentos')
                            <form action="{{ route('orcamento::orcamentos.destroy', $orcamento->orc_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este orcamento?');">
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
                        <td colspan="7" class="text-center text-muted py-4">Nenhum orcamento encontrado.</td>
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
