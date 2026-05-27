# Modulo Seguranca

## Objetivo

Centralizar autenticacao, autorizacao e auditoria do sistema.

## Funcionalidades

- Gestao de sistemas, modulos e funcionalidades.
- Gestao de privilegios e dependencias de privilegios.
- Gestao de papeis e usuarios.
- Consulta de logs.

## Rotas

Prefixo: seguranca

- resources: sistemas, modulos, funcionalidades, privilegios, papeis, usuarios, logs
- usuarios.validaLogin
- usuarios.atualizaSenha
- privilegios.destroydep

## ACL

- Middleware acl valida acesso por controller + action.
- Privilegios e dependencias determinam se rota pode ser executada.

## Regras de Negocio

- Toda nova rota protegida deve ter privilegio correspondente.
- Dependencias devem cobrir acoes complementares (store/update etc.).
- Alteracoes em permissao precisam ser refletidas em seed e testes.

## Testes Recomendados

- Acesso autorizado e nao autorizado por papel.
- Fluxos de usuario (senha, login, perfil).
- Integridade de vinculos papel x privilegio.
