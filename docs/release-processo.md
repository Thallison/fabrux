# Processo de Release

## Objetivo

Padronizar como mudancas chegam ao ambiente de homologacao/producao com seguranca e rastreabilidade.

## Modelo de Entrega

1. Branch por demanda.
2. PR com checklist completo.
3. Validacao tecnica e funcional.
4. Merge para branch principal.
5. Deploy conforme janela acordada.

## Checklist Pre-Release

- Testes relevantes executados e verdes.
- Pint executado.
- Seeds/migrations revisados para impacto em dados existentes.
- Permissoes ACL validadas.
- Documentacao atualizada.

## Rollback

- Para mudancas de codigo: rollback de deploy para versao anterior.
- Para mudancas de dados: script de reversao previamente revisado.
- Para seeds: manter script de limpeza idempotente por modulo.

## Evidencias Minimas

- Link do PR.
- Lista de arquivos/areas impactadas.
- Resultado de testes.
- Plano de rollback.

## Boas Praticas

- Evitar release com multiplas mudancas criticas sem separacao de risco.
- Preferir incrementos pequenos e frequentes.
- Registrar incidentes e aprendizado em ADR/FAQ quando aplicavel.
