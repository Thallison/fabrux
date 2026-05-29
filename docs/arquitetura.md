# Arquitetura do Projeto

## Visao Geral

O Fabrux e um sistema modular de MES baseado em Laravel 12, com responsabilidades separadas por modulo de negocio.

- Base: infraestrutura reutilizavel (BaseController, BaseModel, servicos comuns).
- Seguranca: autenticacao, autorizacao (ACL), papeis, privilegios, logs.
- Cadastros: entidades de referencia (funcionarios, produtos, clientes).
- Producao: operacao de producao e dashboard.
- Relatorios: consultas gerenciais e analiticas.

## Estilo Arquitetural

- Modular monolith: modulos independentes no mesmo deploy.
- MVC por modulo: controllers, models, views e rotas isoladas.
- Convencao orientada a BaseController/BaseModel para reduzir codigo repetido.
- ACL por privilegios e acoes de controller.
- Frontend progressivamente orientado a padroes globais de JS, reduzindo inicializacao inline por tela.

## Estrutura Principal

- app/: camada global da aplicacao (middleware, providers etc.).
- Modules/: codigo funcional por modulo.
- bootstrap/app.php: configuracao de middleware e inicializacao.
- routes/: rotas globais (quando aplicavel).
- resources/: assets, JS global e views compartilhadas.
- tests/: testes feature e unit (Pest).

## Fluxo de Requisicao (Web)

1. Rota do modulo resolve controller.
2. Middlewares aplicam autenticacao, email verificado e ACL.
3. BaseController valida dados usando rules() do model.
4. Model persiste com Eloquent e retorna para view/json.
5. Frontend usa Bootstrap Table e utilitarios JS globais para interacao.

## Principais Convencoes

- Nome de rota por modulo: modulo::recurso.acao.
- Rotas de modulo agrupadas por prefixo e middleware.
- Validacao centralizada nos models via rules().
- Campos de status com padrao 1/0 para ativo/inativo.
- Selects enriquecidos com busca devem usar inicializacao global por atributo `data-tom-select`.
- Views devem manter terminologia consistente e linguagem funcional alinhada entre modulo, PDF e acoes da UI.

## Riscos Tecnicos Conhecidos

- Seeds com IDs fixos exigem governanca entre modulos.
- Mudancas em ACL exigem sincronia entre rotas, privilegios e dependencias.
- Alteracoes em JS global podem impactar multiplas telas.
- Padroes de frontend nao documentados tendem a gerar inicializacoes duplicadas e regressao visual entre modulos.

## Evolucao Recomendada

- Migrar seeds para estrategia idempotente (upsert/check por chave funcional).
- Criar matriz de permissoes por modulo em documentacao dedicada.
- Padronizar checklist de PR para rotas + privilegios + testes.
