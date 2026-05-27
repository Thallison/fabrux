# Guia de Contribuicao

## Objetivo

Padronizar como contribuir no projeto com seguranca, rastreabilidade e qualidade.

## Fluxo de Trabalho

1. Crie branch a partir da principal.
2. Implemente alteracoes pequenas e focadas.
3. Rode formatacao e testes locais.
4. Abra PR com contexto funcional e tecnico.
5. Resolva review mantendo historico claro.

## Convencao de Branch

- feat/nome-curto-da-feature
- fix/nome-curto-do-bug
- docs/assunto-documentacao
- refactor/area-impactada

## Convencao de Commit

- feat: nova funcionalidade
- fix: correcao de bug
- docs: alteracao de documentacao
- refactor: melhoria sem mudar comportamento esperado
- test: adicao/ajuste de testes
- chore: tarefas internas/manutencao

## Checklist de PR

- Objetivo e escopo claros.
- Rotas/permissoes atualizadas quando necessario.
- Testes adicionados/ajustados para comportamento alterado.
- Pint executado.
- Evidencias (prints, logs, passos de reproducao) quando aplicavel.

## Regras para Mudancas Modulares

- Nao misturar mudancas de modulos sem necessidade.
- Manter convencoes do modulo existente.
- Ao adicionar recurso novo: rota + view + permissao + seed + teste.

## Referencias

- arquitetura.md
- guia-de-estilo.md
- testes.md
- ia-copilot.md
