# Guia de Uso do Copilot

## Objetivo

Usar IA como acelerador de desenvolvimento mantendo padrao arquitetural do Fabrux.

## Prompt Base Recomendado

Sempre contextualize:

1. Modulo alvo (Base/Cadastros/Producao/Relatorios/Seguranca).
2. Tipo de mudanca (bugfix, feature, refactor, teste, docs).
3. Restricoes (nao quebrar rotas/permissoes/seeds).
4. Resultado esperado (criterios objetivos).

## Boas Praticas

- Solicite analise antes de alterar arquivos criticos.
- Peca comparacao com padrao existente do modulo.
- Exija atualizacao de testes e documentacao quando houver mudanca funcional.
- Revise sempre IDs de seed e impacto em ACL.

## Checklist para Mudancas com IA

- Rotas e privilegios alinhados.
- Validacao backend + frontend coerentes.
- Sem regressao em CRUD principal.
- Seeds sem colisao de IDs.
- Docs atualizadas no modulo correspondente.
- Padroes globais de frontend preservados (sem duplicar inicializacao local desnecessaria).

## Prompts Uteis

- "Analise este modulo e aplique o mesmo padrao usado em X."
- "Crie testes de CRUD com Pest cobrindo validacao e ACL."
- "Revise esta view comparando com o contrato do BaseController."
- "Atualize seed com IDs livres e sem conflito entre modulos."

## Limites e Cautelas

- Nunca assumir que seed com ID fixo esta livre sem validar.
- Evitar alteracoes amplas em multiplos modulos de uma vez.
- Nao confiar em validacao apenas de frontend.

## Integracao com esta Documentacao

Antes de pedir codigo para IA:

1. Consulte docs/modulos/README.md.
2. Consulte o README do modulo alvo em docs/modulos/<modulo>/README.md.
3. Consulte docs/padroes-frontend.md quando a tarefa envolver views, JS, filtros ou componentes de formulario.
4. Defina explicitamente qual regra/documento deve ser seguido.
