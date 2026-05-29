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

## Camada Global de UX

Arquivo principal da camada de experiencia compartilhada:

- resources/js/core/ux.js

Responsabilidades atuais:

- aplicar loading state em botoes de submit e confirmacao
- exibir placeholder de carregamento para modais assincronos
- normalizar estrutura visual de formularios sem refatoracao manual por view
- criar empty state para grids baseadas em Bootstrap Table
- aplicar foco visivel, animacoes de entrada e suporte basico para navegacao por teclado

### Regra

- antes de criar JS local para loading, empty state, hover, focus ou microinteracao, verificar se a necessidade pode ser atendida pela camada global existente

## Sistema Visual Compartilhado

O backoffice agora usa um conjunto de classes e estilos globais para manter consistencia entre modulos.

Principais blocos:

- `fabrux-backoffice`: contexto visual do layout autenticado
- `fabrux-topbar` e `fabrux-sidebar`: navegacao principal
- `fabrux-form` e `fabrux-form-actions`: padrao visual de formularios
- `fabrux-kpi-box`: cards de indicadores usados em dashboards e relatorios
- `fabrux-dashboard-intro`: bloco introdutorio de telas analiticas
- `fabrux-data-table-card`: acabamento compartilhado para cards com tabelas/listagens

### Regra

- para dashboards e relatorios, preferir reutilizar `fabrux-kpi-box`, `fabrux-dashboard-intro` e subtitulos de card antes de criar estilos locais
- para listagens, preferir o acabamento global do Bootstrap Table e dos cards ja definido em `resources/scss/app.scss`

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
- quando o select estiver dentro de tabelas responsivas, cards com overflow ou containers rolaveis, renderizar o dropdown fora do container com `dropdownParent: 'body'`

### Caso comum: selects dinamicos em tabelas

Quando uma linha e criada dinamicamente dentro de uma tabela com `table-responsive`, o dropdown do Tom Select pode ficar cortado pelo overflow do container. Nesses casos:

- inicializar o select apenas no elemento `select` original
- usar `dropdownParent: 'body'` para o menu ficar visivel fora da tabela
- evitar seletores genericos que tambem atinjam elementos auxiliares criados pelo plugin
- se a linha for criada por botao, preferir focar e abrir o select logo apos a insercao para reforcar o feedback visual ao usuario

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

## Padrao para Botoes de Acao

Para manter consistencia entre listagens, telas de detalhe e acoes de formulario:

- quando o botao tiver icone e texto, adicionar espacamento no icone com utilitario Bootstrap (`me-1`)
- em grupos de acoes no cabecalho de cards/telas, alinhar o conjunto a direita no desktop com `ms-lg-auto` e `justify-content-lg-end`
- manter `flex-wrap` no grupo para nao quebrar layout em telas menores
- manter os botoes com `d-inline-flex align-items-center` quando houver icone para garantir alinhamento vertical uniforme

Exemplo recomendado para grupo de acoes:

```html
<div class="d-flex flex-wrap gap-2 ms-lg-auto justify-content-lg-end">
  <a class="btn btn-outline-primary d-inline-flex align-items-center" href="#">
    <i class="bi bi-download me-1"></i> Baixar PDF
  </a>
</div>
```

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
- Relatorios

## Checklist de PR para Frontend

- componente novo aproveita utilitario global existente quando possivel
- select enriquecido usa `data-tom-select`
- placeholder faz sentido para o contexto do campo
- nao ha inicializacao duplicada do mesmo plugin
- dropdowns continuam visiveis mesmo dentro de containers com overflow
- botoes com icone mantem espacamento visual consistente (icone + texto)
- grupos de acoes no topo de tela ficam alinhados a direita no desktop
- textos visiveis seguem terminologia consistente
- dashboards e relatorios reutilizam os cards KPI e o intro panel compartilhado quando aplicavel
- interacoes simples de loading, empty state e foco usam a camada global antes de scripts locais