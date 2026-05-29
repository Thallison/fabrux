@extends('layouts.default')

@section('page-title', 'Configuração do Cabeçalho')

@section('content')
<div class="card border-0 shadow-sm mb-4 fabrux-section-card" style="background: linear-gradient(130deg, #fff7ed, #f0f9ff);">
    <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <h3 class="mb-1">Cabeçalho do PDF</h3>
            <p class="text-muted mb-0">Defina os dados da empresa que aparecerão no documento enviado ao cliente.</p>
        </div>
        <a href="{{ route('orcamento::orcamentos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="card card-default fabrux-form">
    <form method="POST" action="{{ route('orcamento::orcamentos.header-config.save') }}">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome da Empresa</label>
                    <input type="text" name="orc_cab_nome" class="form-control @error('orc_cab_nome') is-invalid @enderror" value="{{ old('orc_cab_nome', $cabecalho?->orc_cab_nome) }}">
                    @error('orc_cab_nome')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Documento (CNPJ/CPF)</label>
                    <input type="text" name="orc_cab_documento" class="form-control @error('orc_cab_documento') is-invalid @enderror" value="{{ old('orc_cab_documento', $cabecalho?->orc_cab_documento) }}">
                    @error('orc_cab_documento')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Endereco</label>
                    <input type="text" name="orc_cab_endereco" class="form-control @error('orc_cab_endereco') is-invalid @enderror" value="{{ old('orc_cab_endereco', $cabecalho?->orc_cab_endereco) }}">
                    @error('orc_cab_endereco')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="orc_cab_telefone" class="form-control @error('orc_cab_telefone') is-invalid @enderror" value="{{ old('orc_cab_telefone', $cabecalho?->orc_cab_telefone) }}">
                    @error('orc_cab_telefone')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="orc_cab_email" class="form-control @error('orc_cab_email') is-invalid @enderror" value="{{ old('orc_cab_email', $cabecalho?->orc_cab_email) }}">
                    @error('orc_cab_email')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Site</label>
                    <input type="text" name="orc_cab_site" class="form-control @error('orc_cab_site') is-invalid @enderror" value="{{ old('orc_cab_site', $cabecalho?->orc_cab_site) }}">
                    @error('orc_cab_site')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Rodape</label>
                    <textarea name="orc_cab_rodape" rows="4" class="form-control @error('orc_cab_rodape') is-invalid @enderror" placeholder="Mensagem final, observações comerciais, dados bancários, etc.">{{ old('orc_cab_rodape', $cabecalho?->orc_cab_rodape) }}</textarea>
                    @error('orc_cab_rodape')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-end fabrux-form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-floppy"></i> Salvar Configuração
            </button>
        </div>
    </form>
</div>
@endsection
