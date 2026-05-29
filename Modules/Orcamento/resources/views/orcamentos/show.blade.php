@extends('layouts.default')

@section('page-title', 'Detalhes do Orcamento')

@section('content')
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #f3f8ff, #f6fff8);">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between gap-3">
        <div>
            <h3 class="mb-1">{{ $orcamento->orc_numero }}</h3>
            <p class="text-muted mb-0">Cliente: {{ $orcamento->cliente?->cli_nome ?? '-' }}</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @can('Visualizar Orcamentos')
            <a href="{{ route('orcamento::orcamentos.preview-pdf', $orcamento->orc_id) }}" target="_blank" class="btn btn-outline-dark">
                <i class="bi bi-eye"></i> Visualizar PDF
            </a>
            <a href="{{ route('orcamento::orcamentos.download-pdf', $orcamento->orc_id) }}" class="btn btn-outline-primary">
                <i class="bi bi-download"></i> Baixar PDF
            </a>
            <a href="{{ route('orcamento::orcamentos.send-whatsapp', $orcamento->orc_id) }}" target="_blank" class="btn btn-outline-success">
                <i class="bi bi-whatsapp"></i> Enviar WhatsApp
            </a>
            @endcan

            <a href="{{ route('orcamento::orcamentos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card card-default h-100">
            <div class="card-header">
                <h5 class="mb-0">Resumo</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Data de Criacao</label>
                        <div class="fw-semibold">{{ optional($orcamento->orc_data_emissao)->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Validade</label>
                        <div class="fw-semibold">{{ optional($orcamento->orc_data_validade)->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Status</label>
                        <div class="fw-semibold">{{ $orcamento->orc_status }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Desconto</label>
                        <div class="fw-semibold">{{ number_format((float) $orcamento->orc_desconto_percentual, 2, ',', '.') }}%</div>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small">Observacoes</label>
                        <div>{{ $orcamento->orc_observacoes ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-default h-100">
            <div class="card-header">
                <h5 class="mb-0">Totais</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <strong>R$ {{ number_format((float) $orcamento->orc_subtotal, 2, ',', '.') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Desconto</span>
                    <strong>R$ {{ number_format((float) $orcamento->orc_valor_desconto, 2, ',', '.') }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                    <span>Total</span>
                    <strong>R$ {{ number_format((float) $orcamento->orc_total, 2, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-default mb-4">
    <div class="card-header">
        <h5 class="mb-0">Itens</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Produto</th>
                    <th class="text-end">Qtd</th>
                    <th class="text-end">Valor Unitario</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orcamento->itens as $item)
                <tr>
                    <td>{{ $item->oci_produto_codigo }}</td>
                    <td>{{ $item->oci_produto_nome }}</td>
                    <td class="text-end">{{ number_format((float) $item->oci_quantidade, 3, ',', '.') }}</td>
                    <td class="text-end">R$ {{ number_format((float) $item->oci_valor_unitario, 2, ',', '.') }}</td>
                    <td class="text-end">R$ {{ number_format((float) $item->oci_total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@can('Enviar Orcamentos')
<div class="card card-default">
    <div class="card-header">
        <h5 class="mb-0">Enviar por E-mail</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('orcamento::orcamentos.send-email', $orcamento->orc_id) }}" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label">E-mail destino</label>
                <input type="email" name="email_destino" class="form-control" value="{{ old('email_destino', $orcamento->cliente?->cli_email) }}" placeholder="cliente@exemplo.com">
            </div>
            <div class="col-md-6">
                <label class="form-label">Assunto</label>
                <input type="text" name="assunto" class="form-control" value="{{ old('assunto', 'Orcamento '.$orcamento->orc_numero) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Mensagem</label>
                <textarea name="mensagem" rows="3" class="form-control">{{ old('mensagem', 'Segue em anexo o orcamento '.$orcamento->orc_numero.'.') }}</textarea>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-envelope"></i> Enviar Orcamento por E-mail
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@endsection
