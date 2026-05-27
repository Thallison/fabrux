# Guia de Estilo

## PHP e Laravel

- Seguir PSR-12 e formatacao com Laravel Pint.
- Usar tipos explicitos em metodos sempre que possivel.
- Preferir nomes descritivos e semanticos para classes/metodos.
- Evitar logica de negocio em views.
- Reaproveitar BaseController e BaseModel para padrao do projeto.

## Rotas e Controllers

- Rotas agrupadas por modulo com prefixo e name.
- Resource controllers quando houver CRUD completo.
- Acoes adicionais devem seguir nomenclatura clara e previsivel.

## Views e Frontend

- Manter consistencia de layout e componentes Bootstrap/AdminLTE.
- Evitar JavaScript duplicado entre telas; preferir utilitarios globais.
- Para grids, usar formatters padronizados no App (JS global).

## Banco e Seeds

- Preferir seeds idempotentes quando possivel.
- Em seeds com IDs fixos, documentar e reservar faixa por modulo.
- Nao reutilizar IDs de funcionalidades/privilegios/dependencias.

## Testes

- Escrever testes de feature para fluxo de negocio.
- Cobrir validacao, permissao e fluxo feliz de CRUD.
- Usar factories sempre que possivel.

## Documentacao

- Atualizar docs ao alterar comportamento funcional.
- Priorizar clareza e exemplos de uso real.
- Manter terminologia consistente entre modulos.
