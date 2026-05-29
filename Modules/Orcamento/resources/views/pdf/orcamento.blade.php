<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Orçamento {{ $orcamento->orc_numero }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #222;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #0d6efd;
        }

        .muted {
            color: #666;
        }

        .box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #d9d9d9;
            padding: 8px;
        }

        th {
            background: #f1f5f9;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 12px;
            width: 45%;
            margin-left: auto;
        }

        .totals td {
            border: none;
            padding: 4px 0;
        }

        .totals .grand {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $cabecalho?->orc_cab_nome ?: 'Orçamento Comercial' }}</h1>
        @if($cabecalho?->orc_cab_documento)
            <div class="muted">Documento: {{ $cabecalho->orc_cab_documento }}</div>
        @endif
        @if($cabecalho?->orc_cab_endereco)
            <div class="muted">{{ $cabecalho->orc_cab_endereco }}</div>
        @endif
        @if($cabecalho?->orc_cab_telefone || $cabecalho?->orc_cab_email)
            <div class="muted">
                {{ $cabecalho?->orc_cab_telefone }}
                @if($cabecalho?->orc_cab_telefone && $cabecalho?->orc_cab_email)
                    |
                @endif
                {{ $cabecalho?->orc_cab_email }}
            </div>
        @endif
        @if($cabecalho?->orc_cab_site)
            <div class="muted">{{ $cabecalho->orc_cab_site }}</div>
        @endif
    </div>

    <div class="box">
        <strong>Orçamento:</strong> {{ $orcamento->orc_numero }}<br>
        <strong>Data de criação:</strong> {{ optional($orcamento->orc_data_emissao)->format('d/m/Y') }}<br>
        <strong>Validade:</strong> {{ optional($orcamento->orc_data_validade)->format('d/m/Y') }}<br>
        <strong>Cliente:</strong> {{ $orcamento->cliente?->cli_nome }}<br>
        @if($orcamento->cliente?->cli_email)
            <strong>Email:</strong> {{ $orcamento->cliente->cli_email }}<br>
        @endif
        @if($orcamento->cliente?->cli_celular || $orcamento->cliente?->cli_telefone)
            <strong>Telefone:</strong> {{ $orcamento->cliente?->cli_celular ?: $orcamento->cliente?->cli_telefone }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Produto</th>
                <th class="text-right">Qtd</th>
                <th class="text-right">Valor Unitário</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamento->itens as $item)
                <tr>
                    <td>{{ $item->oci_produto_codigo }}</td>
                    <td>{{ $item->oci_produto_nome }}</td>
                    <td class="text-right">{{ number_format((float) $item->oci_quantidade, 3, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format((float) $item->oci_valor_unitario, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format((float) $item->oci_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">R$ {{ number_format((float) $orcamento->orc_subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Desconto ({{ number_format((float) $orcamento->orc_desconto_percentual, 2, ',', '.') }}%)</td>
            <td class="text-right">R$ {{ number_format((float) $orcamento->orc_valor_desconto, 2, ',', '.') }}</td>
        </tr>
        <tr class="grand">
            <td>Total</td>
            <td class="text-right">R$ {{ number_format((float) $orcamento->orc_total, 2, ',', '.') }}</td>
        </tr>
    </table>

    @if($orcamento->orc_observacoes)
    <div class="box" style="margin-top: 18px;">
        <strong>Observações</strong><br>
        {{ $orcamento->orc_observacoes }}
    </div>
    @endif

    @if($cabecalho?->orc_cab_rodape)
    <div class="muted" style="margin-top: 24px; font-size: 11px;">
        {{ $cabecalho->orc_cab_rodape }}
    </div>
    @endif
</body>
</html>
