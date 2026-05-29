@extends('layouts.default')

@section('page-title', isset($orcamento) && $orcamento ? 'Editar Orçamento' : 'Novo Orçamento')

@section('content')
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #0d6efd0d, #20c99714);">
    <div class="card-body">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h3 class="mb-1">{{ isset($orcamento) && $orcamento ? 'Editar Orçamento' : 'Criar Orçamento' }}</h3>
                <p class="text-muted mb-0">Selecione seu cliente, monte os itens, aplique desconto e finalize em segundos.</p>
            </div>
            <a href="{{ route('orcamento::orcamentos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<form action="{{ isset($orcamento) && $orcamento ? route('orcamento::orcamentos.update', $orcamento->orc_id) : route('orcamento::orcamentos.store') }}" method="POST" id="formOrcamento">
    @csrf
    @if(isset($orcamento) && $orcamento)
        @method('PUT')
    @endif
    <div class="card card-default mb-4">
        <div class="card-header">
            <h5 class="mb-0">Dados Gerais</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Cliente <span class="text-danger">*</span></label>
                    <select name="cli_id" id="cli_id" class="form-select @error('cli_id') is-invalid @enderror" data-tom-select="true" data-tom-select-placeholder="Selecione um cliente" required>
                        <option value="">Selecione...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->cli_id }}" {{ (string) old('cli_id', $orcamento?->cli_id) === (string) $cliente->cli_id ? 'selected' : '' }}>
                                {{ $cliente->cli_nome }} | {{ $cliente->cli_email }} | {{ $cliente->cli_celular ?: $cliente->cli_telefone }}
                            </option>
                        @endforeach
                    </select>
                    @error('cli_id')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Data de Criação <span class="text-danger">*</span></label>
                    <input type="date" name="orc_data_emissao" class="form-control @error('orc_data_emissao') is-invalid @enderror" value="{{ old('orc_data_emissao', $dataCriacaoPadrao) }}" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()" required>
                    @error('orc_data_emissao')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Validade <span class="text-danger">*</span></label>
                    <input type="date" name="orc_data_validade" class="form-control @error('orc_data_validade') is-invalid @enderror" value="{{ old('orc_data_validade', $dataValidadePadrao) }}" onclick="this.showPicker && this.showPicker()" onfocus="this.showPicker && this.showPicker()" required>
                    @error('orc_data_validade')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Desconto (%)</label>
                    <input type="text" name="orc_desconto_percentual" id="orc_desconto_percentual" class="form-control @error('orc_desconto_percentual') is-invalid @enderror" value="{{ old('orc_desconto_percentual', number_format((float) ($orcamento?->orc_desconto_percentual ?? 0), 2, ',', '.')) }}" placeholder="0,00">
                    @error('orc_desconto_percentual')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Observações</label>
                    <textarea name="orc_observacoes" rows="3" class="form-control @error('orc_observacoes') is-invalid @enderror" placeholder="Condições comerciais, prazo de entrega, garantia, etc.">{{ old('orc_observacoes', $orcamento?->orc_observacoes) }}</textarea>
                    @error('orc_observacoes')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Itens do Orçamento</h5>
            <button type="button" id="btnAdicionarItem" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Adicionar Item
            </button>
        </div>
        <div class="card-body">
            @error('itens')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="table-responsive">
                <table class="table align-middle" id="tabelaItens">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Produto</th>
                            <th style="width: 14%;">Quantidade</th>
                            <th style="width: 18%;">Valor Unitário</th>
                            <th style="width: 18%;">Total</th>
                            <th style="width: 12%;" class="text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-default mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 ms-md-auto">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Subtotal</span>
                        <strong id="subtotalValor">R$ 0,00</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Desconto</span>
                        <strong id="descontoValor">R$ 0,00</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5">
                        <span>Total</span>
                        <strong id="totalValor">R$ 0,00</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> {{ isset($orcamento) && $orcamento ? 'Atualizar Orçamento' : 'Salvar Orçamento' }}
            </button>
        </div>
    </div>
</form>

<datalist id="orcamento-produtos-list"></datalist>
@endsection

@php
    $produtosOrcamento = $produtos->map(function ($produto) {
        return [
            'id' => $produto->prod_id,
            'label' => $produto->prod_codigo.' - '.$produto->prod_nome,
            'valor' => (float) $produto->prod_valor,
        ];
    })->values();
@endphp

@push('scripts')
<script>
    const produtosOrcamento = @json($produtosOrcamento);

    const oldItems = @json(old('itens', $itensIniciais ?? []));

    function moneyFromString(value) {
        const raw = String(value || '').trim();

        if (!raw) {
            return 0;
        }

        if (raw.includes(',') && raw.includes('.')) {
            return Number.parseFloat(raw.replace(/\./g, '').replace(',', '.')) || 0;
        }

        if (raw.includes(',')) {
            return Number.parseFloat(raw.replace(',', '.')) || 0;
        }

        return Number.parseFloat(raw) || 0;
    }

    function formatMoney(value) {
        return Number(value || 0).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    function createItemRow(index, item = null) {
        const tr = document.createElement('tr');

        const quantidade = item?.oci_quantidade || '1';
        const valorUnitario = item?.oci_valor_unitario || '';

        tr.innerHTML = `
            <td>
                <input type="hidden" name="itens[${index}][prod_id]" class="produto-id" value="${item?.prod_id || ''}">
                <input
                    type="text"
                    name="itens[${index}][produto_label]"
                    class="form-control produto-label"
                    list="orcamento-produtos-list"
                    value="${item?.produto_label || ''}"
                    placeholder="Digite para buscar produto"
                    required
                >
                <div class="invalid-feedback d-block" data-item-error="prod_id"></div>
            </td>
            <td>
                <input type="text" name="itens[${index}][oci_quantidade]" class="form-control item-quantidade" value="${quantidade}" required>
                <div class="invalid-feedback d-block" data-item-error="oci_quantidade"></div>
            </td>
            <td>
                <input type="text" name="itens[${index}][oci_valor_unitario]" class="form-control item-valor" value="${valorUnitario}" data-mask-money required>
                <div class="invalid-feedback d-block" data-item-error="oci_valor_unitario"></div>
            </td>
            <td>
                <input type="text" class="form-control item-total" value="R$ 0,00" readonly>
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-outline-danger btn-remover-item">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        return tr;
    }

    function atualizarTotais() {
        const linhas = document.querySelectorAll('#tabelaItens tbody tr');
        let subtotal = 0;

        linhas.forEach((linha) => {
            const quantidadeInput = linha.querySelector('.item-quantidade');
            const valorInput = linha.querySelector('.item-valor');
            const totalInput = linha.querySelector('.item-total');

            const quantidade = moneyFromString(quantidadeInput.value);
            const valorUnitario = moneyFromString(valorInput.value);

            const total = quantidade * valorUnitario;
            subtotal += total;

            totalInput.value = formatMoney(total);
        });

        const descontoPercentual = moneyFromString(document.getElementById('orc_desconto_percentual').value);
        const desconto = subtotal * (Math.max(0, Math.min(descontoPercentual, 100)) / 100);
        const total = subtotal - desconto;

        document.getElementById('subtotalValor').textContent = formatMoney(subtotal);
        document.getElementById('descontoValor').textContent = formatMoney(desconto);
        document.getElementById('totalValor').textContent = formatMoney(total);
    }

    function preencherProdutoPorLabel(inputLabel) {
        const linha = inputLabel.closest('tr');
        const hiddenId = linha.querySelector('.produto-id');
        const valorInput = linha.querySelector('.item-valor');

        const encontrado = produtosOrcamento.find((produto) => produto.label === inputLabel.value);

        if (!encontrado) {
            hiddenId.value = '';
            return;
        }

        hiddenId.value = encontrado.id;

        if (!valorInput.value.trim()) {
            valorInput.value = App.maskMoney(String(Math.round(encontrado.valor * 100)));
        }

        atualizarTotais();
    }

    function popularDatalistProdutos() {
        const dataList = document.getElementById('orcamento-produtos-list');

        produtosOrcamento.forEach((produto) => {
            const option = document.createElement('option');
            option.value = produto.label;
            dataList.appendChild(option);
        });
    }

    function popularErrosDeItens() {
        const errors = @json($errors->toArray());

        Object.entries(errors).forEach(([campo, mensagens]) => {
            if (!campo.startsWith('itens.')) {
                return;
            }

            const nomeCampo = campo.replace(/\.(\d+)\./, '[$1][').replace(/\./g, ']').replace('itens[', 'itens[');
            const input = document.querySelector(`[name="${nomeCampo}"]`);

            if (!input) {
                return;
            }

            input.classList.add('is-invalid');
            const wrapper = input.closest('td')?.querySelector('[data-item-error]');

            if (wrapper) {
                wrapper.textContent = mensagens[0];
            }
        });
    }

    function adicionarLinha(item = null) {
        const tbody = document.querySelector('#tabelaItens tbody');
        const index = tbody.querySelectorAll('tr').length;
        const linha = createItemRow(index, item);
        tbody.appendChild(linha);
        atualizarTotais();
    }

    document.addEventListener('DOMContentLoaded', function () {
        popularDatalistProdutos();

        if (oldItems.length) {
            oldItems.forEach((item) => {
                adicionarLinha(item);
            });
        } else {
            adicionarLinha();
        }

        popularErrosDeItens();

        document.getElementById('btnAdicionarItem').addEventListener('click', function () {
            adicionarLinha();
        });

        document.getElementById('orc_desconto_percentual').addEventListener('input', atualizarTotais);

        document.addEventListener('input', function (event) {
            const linha = event.target.closest('#tabelaItens tbody tr');

            if (!linha) {
                return;
            }

            if (event.target.classList.contains('produto-label')) {
                preencherProdutoPorLabel(event.target);
            }

            if (event.target.classList.contains('item-quantidade') || event.target.classList.contains('item-valor')) {
                atualizarTotais();
            }
        });

        document.addEventListener('blur', function (event) {
            const linha = event.target.closest('#tabelaItens tbody tr');

            if (!linha) {
                return;
            }

            if (event.target.classList.contains('produto-label')) {
                preencherProdutoPorLabel(event.target);
            }
        }, true);

        document.addEventListener('click', function (event) {
            const botaoRemover = event.target.closest('.btn-remover-item');

            if (!botaoRemover) {
                return;
            }

            const linhas = document.querySelectorAll('#tabelaItens tbody tr');

            if (linhas.length <= 1) {
                return;
            }

            botaoRemover.closest('tr').remove();
            atualizarTotais();
        });
    });
</script>
@endpush
