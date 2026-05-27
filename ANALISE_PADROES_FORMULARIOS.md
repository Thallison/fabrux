# 📋 ANÁLISE COMPLETA DE PADRÕES DE FORMULÁRIOS - FABRUX

**Data:** 5 de Maio de 2026  
**Escopo:** Análise de todos os formulários create/edit do projeto

---

## 1️⃣ FORMULÁRIOS ENCONTRADOS

### Create Forms:
1. ✅ [Modules/Cadastros/resources/views/cliente/create.blade.php](Modules/Cadastros/resources/views/cliente/create.blade.php)
2. ✅ [Modules/Seguranca/resources/views/usuarios/create.blade.php](Modules/Seguranca/resources/views/usuarios/create.blade.php)
3. ✅ [Modules/Seguranca/resources/views/papeis/create.blade.php](Modules/Seguranca/resources/views/papeis/create.blade.php)
4. ✅ [Modules/Seguranca/resources/views/funcionalidades/create.blade.php](Modules/Seguranca/resources/views/funcionalidades/create.blade.php)

### Edit Forms:
1. ✅ [Modules/Cadastros/resources/views/cliente/edit.blade.php](Modules/Cadastros/resources/views/cliente/edit.blade.php)
2. ✅ [Modules/Seguranca/resources/views/usuarios/edit.blade.php](Modules/Seguranca/resources/views/usuarios/edit.blade.php)
3. ✅ [Modules/Seguranca/resources/views/papeis/edit.blade.php](Modules/Seguranca/resources/views/papeis/edit.blade.php)
4. ✅ [Modules/Seguranca/resources/views/funcionalidades/edit.blade.php](Modules/Seguranca/resources/views/funcionalidades/edit.blade.php)

**TOTAL:** 8 formulários (4 create + 4 edit)

---

## 2️⃣ ANÁLISE DETALHADA POR FORMULÁRIO

### 🟦 CLIENTE (Cadastros Module)

#### Layout & Estrutura:
- **Tipo de Layout:** Card-based com rows/cols Bootstrap
- **Colunas Predominantes:** 2, 3 e 4 colunas (responsivo com md)
- **Distribuição:**
  - Row 1: 2 colunas (6/6) - código + tipo
  - Row 2: 2 colunas (8/4) - nome + CPF/CNPJ
  - Row 3: 2 colunas (6/6) - IE + IM (opcional, condicional)
  - Row 4: 1 coluna - CEP
  - Row 5: 2 colunas (8/4) - logradouro + número
  - Row 6: 1 coluna - complemento
  - Row 7: 2 colunas (6/6) - bairro + cidade
  - Row 8: 1 coluna (2) - estado (UF)
  - Row 9: 3 colunas (4/4/4) - telefone + celular + email
  - Row 10: 1 coluna (4) - ativo (select)

#### Estrutura HTML de Campo:
```blade
<div class="row mb-3">
    <div class="col-md-8">
        <div class='form-group'>
            <label class="form-label">
                {{ $model->getAttributeLabel('cli_logradouro') }} 
                <span class="text-danger">*</span>
            </label>
            <input 
                class="form-control @error('cli_logradouro') is-invalid @enderror" 
                type="text" 
                name="cli_logradouro" 
                id="cli_logradouro" 
                required 
                placeholder="Rua, Avenida, etc..." 
                value="{{ old('cli_logradouro', $dados->cli_logradouro ?? '') }}" 
            />
            @error('cli_logradouro')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
```

#### Tratamento de Erros:
- **Classes:** `@error('field') is-invalid @enderror` no input
- **Mensagem de Erro:** `<span class="invalid-feedback" role="alert">`
- **Exibição:** Bootstrap's invalid-feedback (display automático com is-invalid)
- **Acessibilidade:** `role="alert"` para leitores de tela

#### Elementos Especiais:

**1. Campos Read-Only (Código):**
```blade
<input 
    class="form-control" 
    type="text" 
    name="cli_codigo" 
    id="cli_codigo" 
    readonly 
    placeholder="Será gerado automaticamente" 
    style="background-color: #e9ecef;" 
/>
```

**2. Radio Buttons com Validação:**
```blade
<div class="form-check form-check-inline">
    <input 
        class="form-check-input" 
        type="radio" 
        name="cli_tipo" 
        id="cli_tipo_f" 
        value="F" 
        {{ old('cli_tipo') == 'F' ? 'checked' : '' }} 
        onchange="updateCpfCnpjMask()"
    >
    <label class="form-check-label" for="cli_tipo_f">{{ __('Pessoa Física') }}</label>
</div>
```

**3. Spinner Loader (CEP):**
```blade
<label class="form-label">
    {{ $model->getAttributeLabel('cli_cep') }} 
    <span class="text-danger">*</span>
    <span id="cepLoader" class="spinner-border spinner-border-sm ms-2" role="status" style="display: none;">
        <span class="visually-hidden">{{ __('Buscando...') }}</span>
    </span>
</label>
```

**4. Campos Condicionais (IE/IM - Mostrados/Escondidos):**
```blade
<div class="row mb-3" id="inscricoes-group" style="display: none;">
    <!-- Campo IE e IM aparecem apenas para Pessoa Jurídica -->
</div>
```

**5. Mensagens Auxiliares:**
```blade
<small id="cpf_cnpj_error" class="form-text text-danger" style="display: none;">
    {{ __('CPF/CNPJ inválido') }}
</small>
```

#### Placeholders:
- ✅ Todos os inputs possuem placeholders descritivos
- Exemplos: "Nome Completo ou Razão Social", "000.000.000-00", "00000-000", "Rua, Avenida, etc..."

#### Validação JavaScript:
```javascript
function updateCpfCnpjMask() {
    const tipo = document.querySelector('input[name="cli_tipo"]:checked').value;
    // Altera labels e placeholders condicionalmente
}

document.getElementById('cli_cpf_cnpj').addEventListener('input', function() {
    // Aplica máscara conforme tipo (CPF ou CNPJ)
});
```

#### Card Structure:
```blade
<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Novo Cliente') }}</h5>
    </div>
    <form action="{{ route('cadastros::clientes.store') }}" method="POST" id="formCliente">
        <div class="card-body">
            <!-- Campos do formulário -->
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('cadastros::clientes.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> {{ __('Cancelar') }}
            </a>
            <button type="submit" class="btn btn-primary" id="btnSubmit">
                <i class="bi bi-floppy"></i> {{ __('Cadastrar') }}
            </button>
        </div>
    </form>
</div>
```

---

### 🟥 USUÁRIOS (Segurança Module)

#### Layout & Estrutura:
- **Tipo de Layout:** Card-based com rows/cols Bootstrap
- **Colunas Predominantes:** 2, 4 e 6 colunas
- **Distribuição:**
  - Row 1: 2 colunas (6/6) - name + login
  - Row 2: 2 colunas (6/6) - email + status
  - Row 3: 3 colunas (4/4/4) - senha + confirmar + botão gerar
  - Row 4: 2 colunas (6/4) - perfil select + botão adicionar
  - **Elemento Dinâmico:** Tabela com lista de perfis adicionados

#### Estrutura HTML de Campo:
```blade
<div class="row mb-3">
    <div class="col-md-6">
        <div class='form-group'>
            <label class="form-label">{{ __($model->getAttributeLabel('usr_name')) }} : <span class="text-danger">*</span></label>
            <input 
                class="form-control @error('usr_name') is-invalid @enderror" 
                type="text" 
                name="usr_name" 
                required  
                placeholder="{{ __($model->getAttributeLabel('usr_name')) }}" 
                value="{{ old('usr_name', $dados->usr_name ?? '') }}" 
            />
            @error('usr_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
```

#### Elementos Especiais:

**1. Select com Validação:**
```blade
<select name="usr_status" class="form-select" required @error('usr_status') is-invalid @enderror>
    <option value="">{{ __('Selecione...') }}</option>
    <option value="1" {{ old('usr_status') == 1 ? 'selected' : '' }}>{{ __('Ativo') }}</option>
    <option value="0" {{ old('usr_status') === 0 ? 'selected' : '' }}>{{ __('Inativo') }}</option>
</select>
```

**2. Componente de Seleção Customizado (Blade Component):**
```blade
<x-seguranca::select-grupo-usuarios
    :papeis="$papeis"
    :selected="old('perfil') ?? null"
    class="filter"
    required
/>
```

**3. Botão Dinâmico com Ícone:**
```blade
<a class="btn btn-xs btn-info btn-float" id="adicionar_perfil" href="#">
    <i class="bi bi-plus"></i> {{ __('Adicionar perfil') }}
</a>
```

**4. Tabela Dinâmica para Perfis:**
```blade
<table class="table table-hover" id="div_perfil">
    <thead>
        <tr>
            <th colspan="2" style="text-align: center">Perfil do usuário</th>
        </tr>
        <tr>
            <th>Perfil</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <!-- Preenchido dinamicamente via JavaScript -->
    </tbody>
</table>
```

#### Validação JavaScript:
```javascript
// Gerador de senha
document.querySelectorAll('.gerarPassword').forEach(btn => {
    btn.addEventListener('click', () => {
        const pass = generatePassword(10);
        document.querySelector('input[name="senha"]').value = pass;
        document.querySelector('input[name="repeat_senha"]').value = pass;
    });
});

// Dinâmic Fields (Perfis)
App.dynamicFields({
    addButton: '#adicionar_perfil',
    container: '#div_perfil',
    beforeAdd: () => { /* validações */ },
    template: () => { /* template HTML */ },
    afterRemove: ({ button }) => { /* limpeza */ }
});

// Validação de Login (com Fetch)
inputLogin?.addEventListener('blur', async (e) => {
    const response = await fetch(url, {
        method: "POST",
        data: { login: e.target.value, _token: token }
    });
});
```

#### Card Structure:
```blade
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Usuário') }}</h5>
        <div class="text-end">
            <a href="{{ route('seguranca::usuarios.index') }}" class="btn btn-info">
                <i class="bi bi-plus"></i> {{ __('Listar Usuários') }}
            </a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
    </div>
    <form action="{{ route('seguranca::usuarios.store') }}" method="POST" name="formUser">
        <div class="card-body">
            <!-- Campos -->
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}</button>
        </div>
    </form>
</div>
```

---

### 🟨 PAPÉIS (Segurança Module)

#### Layout & Estrutura:
- **Tipo de Layout:** Card-base com Pills Navigation + Tab Content (Vertical Pills)
- **Estrutura Principal:**
  - Row 1: 1 coluna - campo papel_nome
  - **Elemento Complexo:** Acordeões aninhados com 4 níveis de hierarquia

#### Estrutura de Navegação:
```blade
<div class="d-flex align-items-start mb-3">
    <div class="nav nav-tabs flex-column nav-pills me-3" id="v-pills-tab" role="tablist">
        @foreach ($sistemas as $i => $sistema)
            <button class="nav-link {{ $active }}" 
                    id="tabSis{{ $sistema->sis_id }}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#tabSis{{ $sistema->sis_id }}" 
                    type="button">
                {{ $sistema->sis_nome }}
            </button>
        @endforeach
    </div>

    <div class="tab-content">
        @foreach ($sistemas as $i => $sistema)
            <div class="tab-pane fade {{ $show }} {{ $active }}" id="tabSis{{ $sistema->sis_id }}">
                <!-- Conteúdo das abas -->
            </div>
        @endforeach
    </div>
</div>
```

#### Estrutura de Acordeões Aninhados:
```blade
<button class="btn btn-secondary w-100 text-start"
        data-bs-toggle="collapse"
        data-bs-target="#collapsible-modulo{{ $modulo->mod_id }}">
    {{ $modulo->mod_nome }}
</button>

<div class="collapse mt-1" id="collapsible-modulo{{ $modulo->mod_id }}">
    <div class="card card-body">
        <!-- Nível N1: funcPaiModulos -->
        <button class="btn btn-secondary w-100 text-start"
                data-bs-toggle="collapse"
                data-bs-target="#collapsible-funcPai{{ $funcPai->func_id }}">
            {{ $funcPai->func_label }}
        </button>

        <div class="collapse mt-1" id="collapsible-funcPai{{ $funcPai->func_id }}">
            <div class="card card-body">
                <!-- Nível N2: funcFilhasN1 -->
                <button class="btn btn-secondary w-100 text-start"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsible-func1{{ $func1->func_id }}">
                    {{ $func1->func_label }}
                </button>

                <div class="collapse mt-1" id="collapsible-func1{{ $func1->func_id }}">
                    <div class="card card-body">
                        <!-- Nível N3: funcFilhasN2 -->
                        <button class="btn btn-secondary w-100 text-start"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapsible-func2{{ $func2->func_id }}">
                            {{ $func2->func_label }}
                        </button>

                        <div class="collapse mt-1" id="collapsible-func2{{ $func2->func_id }}">
                            <!-- Nível N4: Checkboxes de funcionalidades -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

#### Componentes Dinâmicos:
- **Pills Verticais:** Navegação entre sistemas
- **Acordeões em 4 Níveis:** Módulos > Funcionalidades Pai > Funcionalidades N1 > Funcionalidades N2
- **Checkboxes:** No nível mais profundo para selecionar funcionalidades

---

### 🟪 FUNCIONALIDADES (Segurança Module)

#### Layout & Estrutura:
- **Tipo de Layout:** Card-based simples
- **Colunas Predominantes:** 3 e 4 colunas
- **Distribuição:**
  - Row 1: 3 colunas (4/4/4) - label + controller + icon
  - Row 2: 3 colunas (4/4/4) - módulo + função pai + rota padrão
  - Row 3: 2+ colunas - acesso menu + outras opções

#### Estrutura HTML de Campo:
```blade
<div class="row mb-3">
    <div class="col-md-4">
        <div class='form-group'>
            <label class="form-label">{{ __($model->getAttributeLabel('func_label')) }} : <span class="text-danger">*</span></label>
            <input 
                class="form-control @error('func_label') is-invalid @enderror" 
                type="text" 
                name="func_label" 
                required  
                placeholder="{{ __($model->getAttributeLabel('func_label')) }}" 
                value="{{ old('func_label', $dados->func_label ?? '') }}" 
            />
            @error('func_label')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
```

#### Componentes de Seleção Customizados:
```blade
<x-seguranca::select-modulos
    :modulos="$modulos"
    :selected="old('mod_id') ?? null"
    class="filter"
    required
/>
```

#### Select Nativo com Múltiplas Opções:
```blade
<select name="func_id_pai" class="form-select" @error('func_id_pai') is-invalid @enderror>
    <option value="">{{ __('Selecione...') }}</option>
    @foreach($funcAll as $id => $nome)
        <option value="{{ $id }}" {{ old('func_id_pai') == $id ? 'selected' : '' }}>
            {{ $nome }}
        </option>
    @endforeach
</select>
```

---

## 3️⃣ PADRÃO PREDOMINANTE (PADRÃO UNIVERSAL)

### 🎯 Estrutura HTML Padrão:

```blade
<!-- FORMULÁRIO WRAPPER -->
<div class="card card-default">
    <!-- HEADER DO CARD -->
    <div class="card-header">
        <h5 class="card-title">{{ __('Título da Ação') }}</h5>
        <div class="text-end">
            <a href="{{ route('...') }}" class="btn btn-info">
                <i class="bi bi-plus"></i> {{ __('Listar') }}
            </a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
    </div>

    <!-- FORM ELEMENT -->
    <form action="{{ route('...store') }}" method="POST">
        <!-- BODY DO CARD COM CAMPOS -->
        <div class="card-body">
            @csrf
            @method('PUT') {{-- apenas em edit --}}

            <!-- PADRÃO DE LINHA -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class='form-group'>
                        <label class="form-label">
                            {{ $model->getAttributeLabel('field') }} 
                            <span class="text-danger">*</span> {{-- se obrigatório --}}
                        </label>
                        <input 
                            class="form-control @error('field') is-invalid @enderror" 
                            type="text" 
                            name="field" 
                            id="field"
                            required 
                            placeholder="Placeholder descritivo" 
                            value="{{ old('field', $dados->field ?? '') }}" 
                        />
                        @error('field')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- FOOTER COM BOTÕES -->
        <div class="card-footer text-end">
            <a href="{{ route('...index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> {{ __('Cancelar') }}
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-floppy"></i> {{ __('Cadastrar') }}
            </button>
        </div>
    </form>
</div>
```

### 📊 Distribuição de Colunas Padrão:

| Contexto | Distribuição | Bootstrap Classes |
|----------|--------------|-------------------|
| Campo Inteiro | 1 coluna | `col-md-12` |
| Campo Grande | 2 colunas | `col-md-8` + `col-md-4` |
| Dois Campos Iguais | 2 colunas | `col-md-6` + `col-md-6` |
| Três Campos | 3 colunas | `col-md-4` x 3 |
| Rótulo + Campo | Variável | Depende do contexto |
| Grupo de Radios | 2 colunas | `col-md-6` |

### 🎨 Classes CSS Padrão:

```scss
// Container
.card.card-default  // Card Bootstrap com estilo padrão

// Header
.card-header        // Cabeçalho do card
.card-title         // Título h5

// Body
.card-body          // Corpo do card com campos

// Linhas e Colunas
.row.mb-3           // Linha com margin-bottom 3
.col-md-6           // Coluna responsiva (bootstrap breakpoint md)
.col-md-4, .col-md-8, .col-md-12  // Variações

// Formulário
.form-group         // Grupo de campo (label + input)
.form-label         // Label com espaçamento padrão
.form-control       // Input Bootstrap padrão
.form-select        // Select Bootstrap

// Validação
.is-invalid         // Classe aplicada quando há erro
.invalid-feedback   // Mensagem de erro com display condicional

// Flags
.text-danger        // Asterisco vermelho (*) para obrigatório
.text-muted         // Texto cinza para opcional

// Botões
.btn.btn-primary    // Botão principal (submit)
.btn.btn-secondary  // Botão cancelar
.btn.btn-info       // Botão informativo (links)
.btn.btn-warning    // Botão ação especial
.btn.btn-danger     // Botão perigo

// Ícones
.bi.bi-floppy       // Ícone salvar
.bi.bi-arrow-left   // Ícone voltar
.bi.bi-plus         // Ícone adicionar
```

### 🔄 Atributos HTML Padrão:

```html
<!-- Input Text -->
<input 
    class="form-control @error('field') is-invalid @enderror"  
    type="text"
    name="field"
    id="field"
    required
    placeholder="texto descritivo"
    value="{{ old('field', $dados->field ?? '') }}"
/>

<!-- Input Email -->
<input 
    class="form-control @error('field') is-invalid @enderror"
    type="email"
    name="field"
    id="field"
    required
    placeholder="email@exemplo.com"
    value="{{ old('field') }}"
/>

<!-- Input Password -->
<input 
    class="form-control @error('field') is-invalid @enderror"
    type="password"
    name="field"
    placeholder="Senha"
    value=""  {{-- nunca preenchido para senha --}}
/>

<!-- Select -->
<select 
    name="field" 
    class="form-select @error('field') is-invalid @enderror"
    required
>
    <option value="">{{ __('Selecione...') }}</option>
    <option value="1">Opção 1</option>
</select>

<!-- Radio Buttons -->
<div class="form-check form-check-inline">
    <input 
        class="form-check-input" 
        type="radio" 
        name="field" 
        id="field_option1" 
        value="1"
        {{ old('field') == '1' ? 'checked' : '' }}
    />
    <label class="form-check-label" for="field_option1">Opção 1</label>
</div>
```

---

## 4️⃣ PADRÕES ESPECIAIS IDENTIFICADOS

### 🔄 Campos Condicionais (Show/Hide):

**Pattern:** Usar `style="display: none;"` com `id` único, controlado via JavaScript

```blade
<!-- HTML -->
<div id="inscricoes-group" style="display: none;">
    <!-- Campos IE e IM -->
</div>

<!-- JavaScript -->
function updateCpfCnpjMask() {
    const inscricoesGroup = document.getElementById('inscricoes-group');
    inscricoesGroup.style.display = tipo === 'J' ? 'flex' : 'none';
}
```

### ⏳ Spinners/Loaders Dinâmicos:

**Pattern:** Spinner Bootstrap com `style="display: none;"` e JS para toggle

```blade
<span id="cepLoader" class="spinner-border spinner-border-sm ms-2" role="status" style="display: none;">
    <span class="visually-hidden">{{ __('Buscando...') }}</span>
</span>
```

### 📋 Tabelas Dinâmicas (Dynamic Fields):

**Pattern:** Usa helper `App.dynamicFields()` para adicionar/remover linhas

```javascript
App.dynamicFields({
    addButton: '#adicionar_perfil',
    container: '#div_perfil',
    beforeAdd: () => { /* validações antes */ },
    template: () => { /* HTML da nova linha */ },
    afterRemove: ({ button }) => { /* limpeza depois */ }
});
```

### 🔐 Gerador de Senhas:

**Pattern:** Botão com listener que gera senha e preenche dois inputs

```javascript
document.querySelectorAll('.gerarPassword').forEach(btn => {
    btn.addEventListener('click', () => {
        const pass = generatePassword(10);
        document.querySelector('input[name="senha"]').value = pass;
        document.querySelector('input[name="repeat_senha"]').value = pass;
    });
});

function generatePassword(length) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
    return Array.from({ length }, () => 
        chars[Math.floor(Math.random() * chars.length)]
    ).join('');
}
```

### 🎯 Mascaras de Entrada (Input Masks):

**Pattern:** Event listeners com funções de máscara

```javascript
document.getElementById('cli_cpf_cnpj').addEventListener('input', function() {
    const tipo = document.querySelector('input[name="cli_tipo"]:checked').value;
    if (tipo === 'F') {
        this.value = App.maskCpf(this.value);
    } else if (tipo === 'J') {
        this.value = App.maskCnpj(this.value);
    }
});
```

### 🔗 Validação Assíncrona (Fetch):

**Pattern:** Listener blur com POST assíncrono

```javascript
inputLogin?.addEventListener('blur', async (e) => {
    const login = e.target.value;
    const token = document.querySelector('input[name="_token"]').value;

    const response = await fetch('{{ route("seguranca::usuarios.validaLogin") }}', {
        method: "POST",
        data: { login: login, _token: token }
    });

    if (response.login) {
        // Mostrar erro inline
    }
});
```

### 🧩 Componentes Blade Customizados (x-* Components):

**Pattern:** Tags com namespace de módulo

```blade
<x-seguranca::select-grupo-usuarios
    :papeis="$papeis"
    :selected="old('perfil') ?? null"
    class="filter"
    required
/>

<x-seguranca::select-modulos
    :modulos="$modulos"
    :selected="old('mod_id') ?? null"
    class="filter"
    required
/>
```

### 🎨 Acordeões Aninhados (Collapsibles):

**Pattern:** Bootstrap collapse com botões secundários

```blade
<button class="btn btn-secondary w-100 text-start"
        data-bs-toggle="collapse"
        data-bs-target="#collapsible-{{ $id }}">
    {{ $label }}
</button>

<div class="collapse mt-1" id="collapsible-{{ $id }}">
    <div class="card card-body">
        <!-- Conteúdo aninhado -->
    </div>
</div>
```

### 📱 Pills Navigation (Vertical Tabs):

**Pattern:** Bootstrap vertical nav-pills com tab-content

```blade
<div class="d-flex align-items-start mb-3">
    <div class="nav nav-tabs flex-column nav-pills me-3" role="tablist">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab1">
            Sistema 1
        </button>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab1">
            <!-- Conteúdo -->
        </div>
    </div>
</div>
```

---

## 5️⃣ VALIDAÇÃO E MENSAGENS DE ERRO

### 📍 Padrão de Validação Backend → Frontend:

```blade
@error('field_name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
```

### 🎯 Classes Bootstrap para Erros:

1. **Input com Erro:** `class="form-control is-invalid"`
2. **Mensagem de Erro:** `class="invalid-feedback" role="alert"`
3. **Exibição:** Automática via CSS Bootstrap (`.is-invalid ~ .invalid-feedback { display: block; }`)

### ✅ Padrão de Campos Obrigatórios vs Opcionais:

**Obrigatório:**
```blade
<label class="form-label">
    {{ $model->getAttributeLabel('field') }} 
    <span class="text-danger">*</span>
</label>
<input ... required ... />
```

**Opcional:**
```blade
<label class="form-label">
    {{ $model->getAttributeLabel('field') }} 
    <span class="text-muted">({{ __('Opcional') }})</span>
</label>
<input ... />
```

---

## 6️⃣ PLACEHOLDERS E UX

### 📝 Padrão de Placeholders:

| Campo | Placeholder | Exemplo |
|-------|-------------|---------|
| Nome Completo | Descritivo | "Nome Completo ou Razão Social" |
| CPF/CNPJ | Formato | "000.000.000-00" ou "00.000.000/0000-00" |
| CEP | Formato | "00000-000" |
| Telefone | Formato | "(00) 0000-0000" |
| Celular | Formato | "(00) 99999-9999" |
| Email | Exemplo | "email@exemplo.com" |
| Endereço | Tipo | "Rua, Avenida, etc..." |
| Genérico | Label ou Tipo | Usa `$model->getAttributeLabel()` |

### 🌐 Labels com Tradução:

```blade
<!-- Padrão 1: Modelo -->
{{ $model->getAttributeLabel('field') }}

<!-- Padrão 2: Com __() para i18n -->
{{ __($model->getAttributeLabel('field')) }}

<!-- Padrão 3: Tradução Manual -->
{{ __('Texto Traduzido') }}
```

---

## 7️⃣ BUTTONS E AÇÕES

### 🔘 Padrão de Botões:

```blade
<!-- Botão Submeter (Primário) -->
<button type="submit" class="btn btn-primary">
    <i class="bi bi-floppy"></i> {{ __('Cadastrar') }}
</button>

<!-- Botão Cancelar (Secundário) -->
<a href="{{ route('...index') }}" class="btn btn-secondary me-2">
    <i class="bi bi-arrow-left"></i> {{ __('Cancelar') }}
</a>

<!-- Botão Info (Listar) -->
<a href="{{ route('...index') }}" class="btn btn-info">
    <i class="bi bi-plus"></i> {{ __('Listar') }}
</a>

<!-- Botão Pequeno (Extra Small) -->
<a href="#" class="btn btn-xs btn-info btn-float">
    <i class="bi bi-plus"></i> {{ __('Adicionar') }}
</a>

<!-- Botão Remover (Danger) -->
<a href="#" class="btn btn-danger btn-sm">
    <i class="bi bi-x"></i>
</a>

<!-- Botão Ação Especial (Warning) -->
<button type="button" class="btn btn-warning">
    <i class="fa-solid fa-lock"></i> {{ __('Gerar Senha') }}
</button>
```

### 🎯 Posicionamento de Botões:

```blade
<div class="card-footer text-end">
    <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}</button>
</div>
```

---

## 8️⃣ COMPARAÇÃO: CREATE vs EDIT

### 📊 Diferenças Principais:

| Aspecto | CREATE | EDIT |
|---------|--------|------|
| **Form Action** | `route('module::model.store')` | `route('module::model.update', $id)` |
| **Method HTTP** | POST (implícito) | PUT (com `@method('PUT')`) |
| **Valores Iniciais** | `old('field')` | `old('field', $dados->field)` |
| **Senhas** | Obrigatório | Opcional (permite mudança) |
| **Campos Read-Only** | Código gerado | Código existente |
| **CSRF** | Sempre `@csrf` | Sempre `@csrf` + `@method('PUT')` |

### 📝 Exemplos Concretos:

**CREATE:**
```blade
<form action="{{ route('cadastros::clientes.store') }}" method="POST">
    @csrf
    <input value="{{ old('cli_nome') }}" />
    <input type="password" name="senha" required />
    <button type="submit">{{ __('Cadastrar') }}</button>
</form>
```

**EDIT:**
```blade
<form action="{{ route('cadastros::clientes.update', $dados->cli_id) }}" method="POST">
    @csrf
    @method('PUT')
    <input value="{{ old('cli_nome', $dados->cli_nome) }}" />
    <input type="password" name="senha" />
    <button type="submit">{{ __('Atualizar') }}</button>
</form>
```

---

## 9️⃣ RESUMO EXECUTIVO - CHECKLIST PARA NOVOS FORMULÁRIOS

### ✅ Estrutura Obrigatória:

- [ ] Wrapper `<div class="card card-default">`
- [ ] Card Header com `<h5 class="card-title">`
- [ ] Link "Listar" no header
- [ ] Form com `@csrf`
- [ ] `@method('PUT')` se for EDIT
- [ ] Card Body com os campos
- [ ] Card Footer com botões (Cancelar + Submeter)
- [ ] `id="form..."` no form para possíveis referências JS

### ✅ Cada Campo Deve Ter:

- [ ] `<div class="row mb-3">`
- [ ] `<div class="col-md-X">`
- [ ] `<div class="form-group">`
- [ ] `<label class="form-label">` com `getAttributeLabel()`
- [ ] Asterisco `*` se obrigatório com `<span class="text-danger">`
- [ ] Input com `@error() is-invalid @enderror`
- [ ] Placeholder descritivo
- [ ] Value com `old('field', $dados->field ?? '')`
- [ ] Bloco `@error()` com `<span class="invalid-feedback">`

### ✅ Validação:

- [ ] Backend validado no Model (`rules()`) ou Form Request
- [ ] Frontend com Bootstrap validation classes
- [ ] Mensagens de erro em português (i18n)
- [ ] Campos obrigatórios marcados com `*`

### ✅ JavaScript (quando necessário):

- [ ] Máscaras de entrada (CPF, CNPJ, CEP, etc)
- [ ] Campos condicionais com `style="display: none;"`
- [ ] Validação assíncrona de login/email
- [ ] Dinâmic Fields para tabelas
- [ ] Event listeners para interatividade

### ✅ UX:

- [ ] Placeholders em todos os inputs
- [ ] Labels clara e descritivas
- [ ] Spinner para operações assíncronas
- [ ] Mensagens de sucesso/erro
- [ ] Botões com ícones Bootstrap Icons (bi-)
- [ ] Responsividade (col-md-6, col-md-4, etc)

---

## 🔟 EXEMPLOS DE CÓDIGO PRONTO PARA COPIAR/COLAR

### Template Mínimo para Novo Formulário:

```blade
@extends('layouts.default')

@section('page-title', 'Novo Recurso')

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Novo Recurso') }}</h5>
        <div class="text-end">
            <a href="{{ route('modulo::recursos.index') }}" class="btn btn-info">
                <i class="bi bi-list"></i> {{ __('Listar') }}
            </a>
        </div>
    </div>

    <form action="{{ route('modulo::recursos.store') }}" method="POST" id="formRecurso">
        <div class="card-body">
            @csrf

            <!-- Campo de Texto Simples -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">{{ $model->getAttributeLabel('rec_nome') }} <span class="text-danger">*</span></label>
                        <input class="form-control @error('rec_nome') is-invalid @enderror" 
                               type="text" name="rec_nome" id="rec_nome" 
                               required placeholder="Nome do recurso" 
                               value="{{ old('rec_nome') }}" />
                        @error('rec_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Campo Select -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">{{ $model->getAttributeLabel('rec_status') }} <span class="text-danger">*</span></label>
                    <select name="rec_status" class="form-select @error('rec_status') is-invalid @enderror" required>
                        <option value="">{{ __('Selecione...') }}</option>
                        <option value="1" {{ old('rec_status') == 1 ? 'selected' : '' }}>{{ __('Ativo') }}</option>
                        <option value="0" {{ old('rec_status') === 0 ? 'selected' : '' }}>{{ __('Inativo') }}</option>
                    </select>
                    @error('rec_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        </div>

        <div class="card-footer text-end">
            <a href="{{ route('modulo::recursos.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> {{ __('Cancelar') }}
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-floppy"></i> {{ __('Cadastrar') }}
            </button>
        </div>
    </form>
</div>

@endsection
```

---

## 📌 CONCLUSÃO

O projeto **Fabrux** segue um padrão **muito consistente e bem estruturado** de formulários:

✅ **Padrão Universal:** Todos os formulários usam a mesma estrutura (card + rows/cols + validação)  
✅ **Bootstrap 5:** Totalmente baseado em Bootstrap com validação nativa  
✅ **Responsividade:** Usa breakpoints `col-md-*` apropriados  
✅ **Validação:** Backend + Frontend com mensagens de erro claras  
✅ **UX Moderna:** Placeholders, spinners, campos condicionais, mascaras  
✅ **i18n Pronto:** Usa `$model->getAttributeLabel()` e `__()` para traduções  
✅ **Componentes Reutilizáveis:** Blade components customizados para seleções  
✅ **JavaScript Inteligente:** Dynamic fields, mascaras, validação assíncrona  

**Para manter a consistência,** qualquer novo formulário deve seguir este padrão exatamente como descrito no checklist da seção 9.

