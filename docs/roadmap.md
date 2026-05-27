# Roadmap

## Objetivo

Dar visibilidade das evolucoes planejadas por horizonte, com foco em valor de negocio e reducao de risco tecnico.

## Horizonte 0-30 dias

- Consolidar CRUDs de Cadastros com padrao unico de validacao e UX.
- Fechar lacunas de permissao ACL por acao de controller.
- Padronizar seeds com governanca de IDs por modulo.
- Cobrir fluxos criticos com testes de feature (Pest).

## Horizonte 31-90 dias

- Fortalecer modulo Producao com validacoes de consistencia operacional.
- Evoluir relatorios com filtros e exportacoes mais robustas.
- Criar matriz oficial de permissoes por modulo.
- Introduzir ADRs para decisoes de arquitetura de maior impacto.

## Horizonte 91-180 dias

- Migrar seeds fixos para estrategia idempotente orientada a chave funcional.
- Expandir observabilidade (logs estruturados e trilhas por modulo).
- Melhorar onboarding com trilhas por perfil (backend, frontend, produto).

## Backlog Estruturante

- Padrao de mensagens e erros para UI.
- Politica de versionamento e release notes.
- Checklist de qualidade por PR com gates automatizados.

## Criticos de Sucesso

- Reducao de retrabalho em regressao de CRUD e ACL.
- Tempo medio de onboarding reduzido.
- Menor numero de incidentes por conflito de seed/permissao.
