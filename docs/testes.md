# Testes

## Stack

- Pest 4 como framework principal.
- PHPUnit como base de execucao.

## Comandos Principais

- Suite completa:
	- php artisan test --compact
- Filtro por nome:
	- php artisan test --compact --filter=NomeDoTeste
- Arquivo especifico:
	- php artisan test --compact tests/Feature/Cadastros/ClienteTest.php

## Estrategia Recomendada

- Priorizar testes de feature para fluxos de negocio.
- Cobrir CRUD com:
	- sucesso
	- validacoes obrigatorias
	- unicidade
	- autenticacao/autorizacao
- Quando houver JS relevante, validar impacto no backend + view render.

## Padrao por Mudanca

1. Reproduzir bug com teste (quando possivel).
2. Implementar correcao.
3. Garantir teste verde.
4. Rodar Pint.

## Dados de Teste

- Preferir factories.
- Evitar dependencias entre testes.
- Manter nomes e cenarios explicitos.
