# Modulo Producao

## Objetivo

Controlar operacao de producao e acompanhar indicadores do processo produtivo.

## Funcionalidades

- CRUD de producoes.
- Busca de produtos para composicao de producao.
- Dashboard de producao.

## Rotas

Prefixo: producao

- resource producoes
- producoes.searchProdutos
- producoes.dashboard

## Permissoes

- ACL aplicada nas rotas principais de producao.
- Dependencias de privilegio para store/update no seeder do modulo.

## Regras de Negocio

- Integracao com dados de funcionarios e produtos.
- Fluxos devem preservar consistencia de tempos e status operacionais.

## Testes Recomendados

- Criacao e atualizacao de producao.
- Validacao de selecao de produto.
- Permissao de acesso ao modulo.
