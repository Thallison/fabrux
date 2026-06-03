# ADR-0001: Governanca de IDs em Seeds Modulares

## Status

Aprovado

## Contexto

O projeto usa seeds modulares com IDs fixos para funcionalidades, privilegios e dependencias. Colisoes entre modulos ja ocorreram durante evolucao paralela.

## Decisao

- Separar seeds por contexto funcional sempre que necessario.
- Reservar faixa de IDs por modulo e registrar em documentacao.
- Validar conflitos antes de incluir novos IDs fixos.

## Consequencias

### Positivas

- Menor risco de colisao entre modulos.
- Melhor previsibilidade em ambientes compartilhados.
- Facilita manutencao de ACL.

### Riscos

- Exige disciplina de atualizacao documental.
- Pode aumentar custo inicial de criacao de seed.

## Atualizacao de Contexto

- Em evolucoes recentes, alguns recursos novos passaram a usar seed idempotente sem IDs fixos (ex.: funcionalidade Setores em Cadastros).
- O projeto ainda opera em estrategia hibrida (partes legadas com IDs fixos + partes novas idempotentes).
- Diretriz atual: priorizar seed idempotente em novos recursos e evitar criar novos IDs fixos sem necessidade.

## Alternativas Consideradas

- Migrar imediatamente para seeds sem IDs fixos.
- Usar somente auto incremento e buscar por chave funcional.

## Referencias

- docs/arquitetura.md
- docs/modulos/seguranca/README.md
- docs/modulos/cadastros/README.md
