@extends('layouts.default')

@section('page-title', 'Clientes')

@section('content')
<div class="card card-default mb-5">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Editar Cliente') }}</h5>
        <div class="text-end header-elements ms-auto">
            <a href="{{ route('cadastros::clientes.show', ['cliente' => $dados->cli_id]) }}" class="btn btn-info">
                <i class="bi bi-arrow-left"></i> {{ __('Voltar') }}
            </a>
        </div>
    </div>

    <form id="formCliente" method="post" action="{{ route('cadastros::clientes.update', ['cliente' => $dados->cli_id]) }}">
        <div class="card-body">
            @csrf
            @method('PUT')

            <!-- Seleção de Tipo de Pessoa -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">{{ $model->getAttributeLabel('cli_tipo') }} <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cli_tipo" id="tipo_fisico" value="F" {{ old('cli_tipo', $dados->cli_tipo) === 'F' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="tipo_fisico">{{ __('Pessoa Física') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cli_tipo" id="tipo_juridico" value="J" {{ old('cli_tipo', $dados->cli_tipo) === 'J' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="tipo_juridico">{{ __('Pessoa Jurídica') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nome / Razão Social e CPF / CNPJ -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cli_nome" class="form-label" id="label_cli_nome">{{ $model->getAttributeLabel('cli_nome') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_nome" name="cli_nome" class="form-control {{ $errors->has('cli_nome') ? 'is-invalid' : '' }}" placeholder="Digite o nome completo" value="{{ old('cli_nome', $dados->cli_nome) }}" required>
                    @if ($errors->has('cli_nome'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_nome') }}</div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="cli_cpf_cnpj" class="form-label" id="label_cli_cpf_cnpj">{{ $model->getAttributeLabel('cli_cpf_cnpj') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_cpf_cnpj" name="cli_cpf_cnpj" class="form-control {{ $errors->has('cli_cpf_cnpj') ? 'is-invalid' : '' }}" placeholder="000.000.000-00" value="{{ old('cli_cpf_cnpj', $dados->cli_cpf_cnpj) }}" required>
                    <div id="cpf_cnpj_error" class="invalid-feedback" style="display: none;"></div>
                    @if ($errors->has('cli_cpf_cnpj'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_cpf_cnpj') }}</div>
                    @endif
                </div>
            </div>

            <!-- Inscrição Estadual/Municipal (somente para PJ) -->
            <div class="row mb-5" id="inscricoes-group" style="display: {{ $dados->cli_tipo === 'J' ? 'flex' : 'none' }};">
                <div class="col-md-6">
                    <label for="cli_ie" class="form-label">{{ $model->getAttributeLabel('cli_ie') }}</label>
                    <input type="text" id="cli_ie" name="cli_ie" class="form-control" placeholder="Ex: 123.456.789.012" value="{{ old('cli_ie', $dados->cli_ie) }}">
                </div>

                <div class="col-md-6">
                    <label for="cli_im" class="form-label">{{ $model->getAttributeLabel('cli_im') }}</label>
                    <input type="text" id="cli_im" name="cli_im" class="form-control" placeholder="Ex: 1234567" value="{{ old('cli_im', $dados->cli_im) }}">
                </div>
            </div>

            <!-- CONTATO (Email, Telefone, Celular) -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3 text-muted text-uppercase">
                        <i class="bi bi-telephone"></i> {{ __('Informações de Contato') }}
                    </h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="cli_email" class="form-label">{{ $model->getAttributeLabel('cli_email') }} <span class="text-danger">*</span></label>
                    <input type="email" id="cli_email" name="cli_email" class="form-control {{ $errors->has('cli_email') ? 'is-invalid' : '' }}" placeholder="email@exemplo.com" value="{{ old('cli_email', $dados->cli_email) }}" required>
                    @if ($errors->has('cli_email'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_email') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-6">
                    <label for="cli_telefone" class="form-label">{{ $model->getAttributeLabel('cli_telefone') }}</label>
                    <input type="text" id="cli_telefone" name="cli_telefone" class="form-control" placeholder="(11) 3000-0000" value="{{ old('cli_telefone', $dados->cli_telefone) }}">
                </div>

                <div class="col-md-6">
                    <label for="cli_celular" class="form-label">{{ $model->getAttributeLabel('cli_celular') }}</label>
                    <input type="text" id="cli_celular" name="cli_celular" class="form-control" placeholder="(11) 99000-0000" value="{{ old('cli_celular', $dados->cli_celular) }}">
                </div>
            </div>

            <!-- ENDEREÇO (CEP, Logradouro, Número, Complemento, Bairro, Cidade, Estado) -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3 text-muted text-uppercase">
                        <i class="bi bi-geo-alt"></i> {{ __('Endereço') }}
                    </h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="cli_cep" class="form-label">{{ $model->getAttributeLabel('cli_cep') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="cli_cep" name="cli_cep" class="form-control {{ $errors->has('cli_cep') ? 'is-invalid' : '' }}" placeholder="00000-000" value="{{ old('cli_cep', $dados->cli_cep) }}" required>
                        <span id="cepLoader" class="input-group-text" style="display: none;">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </div>
                    @if ($errors->has('cli_cep'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_cep') }}</div>
                    @endif
                    <div id="cepFeedback" class="invalid-feedback" style="display: none;"></div>
                </div>

                <div class="col-md-8">
                    <label for="cli_logradouro" class="form-label">{{ $model->getAttributeLabel('cli_logradouro') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_logradouro" name="cli_logradouro" class="form-control {{ $errors->has('cli_logradouro') ? 'is-invalid' : '' }}" placeholder="Rua, Avenida, etc." value="{{ old('cli_logradouro', $dados->cli_logradouro) }}" required>
                    @if ($errors->has('cli_logradouro'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_logradouro') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="cli_numero" class="form-label">{{ $model->getAttributeLabel('cli_numero') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_numero" name="cli_numero" class="form-control {{ $errors->has('cli_numero') ? 'is-invalid' : '' }}" placeholder="Ex: 123" value="{{ old('cli_numero', $dados->cli_numero) }}" required>
                    @if ($errors->has('cli_numero'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_numero') }}</div>
                    @endif
                </div>

                <div class="col-md-9">
                    <label for="cli_complemento" class="form-label">{{ $model->getAttributeLabel('cli_complemento') }}</label>
                    <input type="text" id="cli_complemento" name="cli_complemento" class="form-control" placeholder="Apt, sala, etc." value="{{ old('cli_complemento', $dados->cli_complemento) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cli_bairro" class="form-label">{{ $model->getAttributeLabel('cli_bairro') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_bairro" name="cli_bairro" class="form-control {{ $errors->has('cli_bairro') ? 'is-invalid' : '' }}" placeholder="Ex: Centro" value="{{ old('cli_bairro', $dados->cli_bairro) }}" readonly>
                    @if ($errors->has('cli_bairro'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_bairro') }}</div>
                    @endif
                </div>

                <div class="col-md-5">
                    <label for="cli_cidade" class="form-label">{{ $model->getAttributeLabel('cli_cidade') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_cidade" name="cli_cidade" class="form-control {{ $errors->has('cli_cidade') ? 'is-invalid' : '' }}" placeholder="Ex: São Paulo" value="{{ old('cli_cidade', $dados->cli_cidade) }}" readonly>
                    @if ($errors->has('cli_cidade'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_cidade') }}</div>
                    @endif
                </div>

                <div class="col-md-2">
                    <label for="cli_estado" class="form-label">{{ $model->getAttributeLabel('cli_estado') }} <span class="text-danger">*</span></label>
                    <input type="text" id="cli_estado" name="cli_estado" class="form-control {{ $errors->has('cli_estado') ? 'is-invalid' : '' }}" maxlength="2" placeholder="SP" value="{{ old('cli_estado', $dados->cli_estado) }}" readonly>
                    @if ($errors->has('cli_estado'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_estado') }}</div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="cli_ativo" class="form-label">{{ $model->getAttributeLabel('cli_ativo') }} <span class="text-danger">*</span></label>
                    <select id="cli_ativo" name="cli_ativo" class="form-select {{ $errors->has('cli_ativo') ? 'is-invalid' : '' }}" data-tom-select="true" data-tom-select-placeholder="Selecione um status" required>
                        <option value="">{{ __('Selecione...') }}</option>
                        <option value="1" {{ old('cli_ativo', (string) $dados->cli_ativo) === '1' ? 'selected' : '' }}>{{ __('Ativo') }}</option>
                        <option value="0" {{ old('cli_ativo', (string) $dados->cli_ativo) === '0' ? 'selected' : '' }}>{{ __('Inativo') }}</option>
                    </select>
                    @if ($errors->has('cli_ativo'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('cli_ativo') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Atualizar') }}</button>
            <a href="{{ route('cadastros::clientes.show', ['cliente' => $dados->cli_id]) }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
        </div>
    </form>
</div>

<script>
    // Rastrear estado de validação do documento
    let validationState = {
        cpfCnpj: false
    };

    function getTipoPessoa() {
        return document.querySelector('input[name="cli_tipo"]:checked').value;
    }

    function getDocumentoLimpo() {
        return document.getElementById('cli_cpf_cnpj').value.replace(/\D/g, '');
    }

    function validarCpfCnpj(exibirErro = true) {
        const tipo = getTipoPessoa();
        const cpfCnpjInput = document.getElementById('cli_cpf_cnpj');
        const errorMsg = document.getElementById('cpf_cnpj_error');
        const documento = getDocumentoLimpo();

        if (tipo === 'F') {
            if (documento.length !== 11) {
                validationState.cpfCnpj = false;
                if (exibirErro && documento.length > 0) {
                    cpfCnpjInput.classList.add('is-invalid');
                    errorMsg.textContent = '{{ __("CPF inválido") }}';
                    errorMsg.style.display = 'block';
                } else {
                    cpfCnpjInput.classList.remove('is-invalid');
                    errorMsg.style.display = 'none';
                }
                return false;
            }

            validationState.cpfCnpj = App.isValidCpf(cpfCnpjInput.value);
            if (validationState.cpfCnpj) {
                cpfCnpjInput.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
            } else if (exibirErro) {
                cpfCnpjInput.classList.add('is-invalid');
                errorMsg.textContent = '{{ __("CPF inválido") }}';
                errorMsg.style.display = 'block';
            }

            return validationState.cpfCnpj;
        }

        if (documento.length !== 14) {
            validationState.cpfCnpj = false;
            if (exibirErro && documento.length > 0) {
                cpfCnpjInput.classList.add('is-invalid');
                errorMsg.textContent = '{{ __("CNPJ inválido") }}';
                errorMsg.style.display = 'block';
            } else {
                cpfCnpjInput.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
            }
            return false;
        }

        validationState.cpfCnpj = App.isValidCnpj(cpfCnpjInput.value);
        if (validationState.cpfCnpj) {
            cpfCnpjInput.classList.remove('is-invalid');
            errorMsg.style.display = 'none';
        } else if (exibirErro) {
            cpfCnpjInput.classList.add('is-invalid');
            errorMsg.textContent = '{{ __("CNPJ inválido") }}';
            errorMsg.style.display = 'block';
        }

        return validationState.cpfCnpj;
    }

    function validarCep() {
        const cep = document.getElementById('cli_cep').value.replace(/\D/g, '');

        return cep.length === 8;
    }

    function updateSubmitButton() {
        const submitBtn = document.querySelector('button[type="submit"]');

        const documento = getDocumentoLimpo();
        const cep = document.getElementById('cli_cep').value.replace(/\D/g, '');

        // Mantem o botao habilitado enquanto campos obrigatorios estao sendo preenchidos.
        // Bloqueia apenas quando o usuario informou documento/CEP em formato invalido.
        if ((documento.length > 0 && !validarCpfCnpj(false)) || (cep.length > 0 && !validarCep())) {
            submitBtn.disabled = true;
            submitBtn.title = '{{ __("Por favor, preencha todos os campos obrigatórios corretamente") }}';
            return;
        }

        submitBtn.disabled = false;
        submitBtn.title = '';
    }

    function updateCpfCnpjMask() {
        const tipo = document.querySelector('input[name="cli_tipo"]:checked').value;
        const nomeInput = document.getElementById('cli_nome');
        const cpfCnpjInput = document.getElementById('cli_cpf_cnpj');
        const labelNome = document.getElementById('label_cli_nome');
        const labelCpfCnpj = document.getElementById('label_cli_cpf_cnpj');
        const inscricoesGroup = document.getElementById('inscricoes-group');

        if (tipo === 'F') {
            labelNome.innerHTML = '{{ $model->getAttributeLabel("cli_nome") }} <span class="text-danger">*</span>';
            nomeInput.placeholder = '{{ __("Digite o nome completo") }}';
            labelCpfCnpj.innerHTML = '{{ __("CPF") }} <span class="text-danger">*</span>';
            cpfCnpjInput.placeholder = '000.000.000-00';
            inscricoesGroup.style.display = 'none';
        } else if (tipo === 'J') {
            labelNome.innerHTML = '{{ __("Razão Social") }} <span class="text-danger">*</span>';
            nomeInput.placeholder = '{{ __("Digite a razão social") }}';
            labelCpfCnpj.innerHTML = '{{ __("CNPJ") }} <span class="text-danger">*</span>';
            cpfCnpjInput.placeholder = '00.000.000/0000-00';
            inscricoesGroup.style.display = 'flex';
        }
    }

    // CPF/CNPJ: Aplicar máscara e validar
    document.getElementById('cli_cpf_cnpj').addEventListener('input', function () {
        const tipo = getTipoPessoa();

        this.value = tipo === 'F' ? App.maskCpf(this.value) : App.maskCnpj(this.value);
        validarCpfCnpj(true);
        updateSubmitButton();
    });

    // CEP: Aplicar máscara e buscar endereço
    document.getElementById('cli_cep').addEventListener('input', function () {
        this.value = App.maskCep(this.value);
    });

    document.getElementById('cli_cep').addEventListener('blur', function () {
        const cepLimpo = this.value.replace(/\D/g, '');
        const cepFeedback = document.getElementById('cepFeedback');

        if (cepLimpo.length === 8) {
            const cepLoader = document.getElementById('cepLoader');
            if (cepLoader) cepLoader.style.display = 'inline-block';

            fetch(`/api/cep/buscar?cep=${encodeURIComponent(this.value)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data && (data.data.logradouro || data.data.localidade)) {
                        document.getElementById('cli_logradouro').value = data.data.logradouro || '';
                        document.getElementById('cli_bairro').value = data.data.bairro || '';
                        document.getElementById('cli_cidade').value = data.data.localidade || '';
                        document.getElementById('cli_estado').value = (data.data.uf || '').toUpperCase();
                        this.classList.remove('is-invalid');
                        cepFeedback.style.display = 'none';
                        document.getElementById('cli_numero').focus();
                    } else {
                        this.classList.add('is-invalid');
                        cepFeedback.textContent = '{{ __("CEP não encontrado") }}';
                        cepFeedback.style.display = 'block';
                    }
                })
                .catch(() => {
                    this.classList.add('is-invalid');
                    cepFeedback.textContent = '{{ __("Erro ao buscar CEP") }}';
                    cepFeedback.style.display = 'block';
                })
                .finally(() => {
                    if (cepLoader) cepLoader.style.display = 'none';
                    updateSubmitButton();
                });
        }

        updateSubmitButton();
    });

    // Telefone e Celular: Máscaras
    ['cli_telefone', 'cli_celular'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', function () {
                this.value = App.maskTelefone(this.value);
            });
        }
    });

    // Estado: Converter para maiúsculas
    document.getElementById('cli_estado').addEventListener('input', function () {
        this.value = this.value.toUpperCase();
    });

    // INICIALIZAÇÃO
    document.addEventListener('DOMContentLoaded', function () {
        updateCpfCnpjMask();
        validarCpfCnpj(false);
        updateSubmitButton();
        
        document.querySelectorAll('input[name="cli_tipo"]').forEach(radio => {
            radio.addEventListener('change', function () {
                updateCpfCnpjMask();
                validarCpfCnpj(false);
                updateSubmitButton();
            });
        });

        // Prevenir submit se houver erros de validação
        document.getElementById('formCliente').addEventListener('submit', function (e) {
            if (!this.checkValidity()) {
                return;
            }

            if (!validarCpfCnpj(true) || !validarCep()) {
                e.preventDefault();
                alert('{{ __("Por favor, preencha todos os campos obrigatórios corretamente") }}');
                updateSubmitButton();
            }
        });
    });
</script>

@endsection
