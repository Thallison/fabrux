# Perguntas Frequentes (FAQ)

## Como configuro o ambiente local?

Siga onboarding.md.

## Como executo os testes?

Use:

- php artisan test --compact

Mais detalhes em testes.md.

## Alterei JS/CSS e nada mudou na tela. E agora?

Rode npm run dev ou npm run build.

## Como saber qual modulo devo alterar?

Veja o mapa em docs/modulos/README.md e depois leia o README do modulo especifico.

## Onde ficam as permissoes de telas?

Nos seeds de cada modulo (funcionalidades, privilegios e dependencias).

## Como evitar conflito em IDs de seed?

Sempre verificar as faixas ja usadas em outros modulos antes de criar novos registros fixos.

## Como manter o Copilot alinhado com o projeto?

Use prompts com contexto de modulo e regras, conforme ia-copilot.md.
