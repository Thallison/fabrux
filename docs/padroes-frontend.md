# Padroes Frontend

## Objetivo

Documentar convencoes de interface, inicializacao de componentes e boas praticas de JS compartilhado no Fabrux.

## Stack Atual

- Bootstrap 5
- AdminLTE
- jQuery (legado e suporte a telas existentes)
- Bootstrap Table
- Tom Select
- Vite para bundle dos assets

## Ponto Central de Inicializacao

Arquivo principal:

- resources/js/app.js

Responsabilidades atuais:

- registrar dependencias globais (`$`, `bootstrap`, `TomSelect`)
- carregar utilitarios JS do projeto
- chamar `App.init()` e `App.initFlash()`
- inicializar selects enriquecidos via atributo `data-tom-select`
- reinicializar componentes em conteudo carregado por modal via evento `modal:loaded`

## Padrao para Selects com Busca

Todo select que precise de busca, autocomplete visual ou UX de dropdown aprimorada deve usar o padrao global abaixo:

```html
<select
    name="campo"
    class="form-select"
    data-tom-select="true"
    data-tom-select-placeholder="Selecione um item"
>
```

### Atributos suportados

- `data-tom-select="true"`: ativa a inicializacao automatica.
- `data-tom-select-placeholder="..."`: placeholder exibido pelo componente.
- `data-tom-select-max-options="500"`: sobrescreve o limite padrao de opcoes quando necessario.

### Regras

- Nao instanciar `new window.TomSelect(...)` manualmente quando o atributo acima for suficiente.
- Evitar scripts locais apenas para ligar selects simples.
- Em modais, confiar na reinicializacao global disparada por `modal:loaded`.
- Usar placeholder contextual, como:
  - `Selecione um cliente`
  - `Selecione um status`
  - `Selecione um modulo`
  - `Todos os clientes`

## Quando usar script local

Script local ainda e aceitavel quando:

- a tela precisa de logica de negocio especifica alem da inicializacao do componente
- ha integracao com campos dinamicos que nao podem ser cobertos so por atributo
- o comportamento depende de callbacks customizados nao padronizados globalmente

Mesmo nesses casos:

- preferir complementar o padrao global em vez de substitui-lo
- nao duplicar inicializacao ja coberta por `app.js`

## Padrao de Linguagem da UI

- Usar portugues tecnico consistente.
- Corrigir acentuacao em rotulos, botoes, tabelas, modais e mensagens.
- Manter os mesmos termos entre listagem, detalhe, PDF e confirmacoes.

Exemplos esperados:

- `Orcamento` -> `Orçamento`
- `Criacao` -> `Criação`
- `Codigo` -> `Código`
- `Usuario` -> `Usuário`
- `Ate` -> `Até`

## Validacao Recomendada para Mudancas Frontend

1. validar diagnosticos do editor nos arquivos alterados
2. compilar assets com Vite
3. revisar a tela afetada no navegador quando a mudanca for visual ou interativa

Comandos uteis:

```bash
php artisan test --compact
```

```bash
npm run build
```

Em Windows/Laragon sem `node` no PATH:

```bash
D:\laragon\bin\nodejs\node-v22\node.exe node_modules\vite\bin\vite.js build
```

## Modulos Ja Padronizados com Este Fluxo

- Orcamento
- Cadastros
- Producao
- Seguranca

## Checklist de PR para Frontend

- componente novo aproveita utilitario global existente quando possivel
- select enriquecido usa `data-tom-select`
- placeholder faz sentido para o contexto do campo
- nao ha inicializacao duplicada do mesmo plugin
- textos visiveis seguem terminologia consistente