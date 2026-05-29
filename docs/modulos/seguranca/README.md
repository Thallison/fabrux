# Modulo Seguranca

## Objetivo

Centralizar autenticacao, autorizacao e auditoria do sistema.

## Funcionalidades

- Gestao de sistemas, modulos e funcionalidades.
- Gestao de privilegios e dependencias de privilegios.
- Gestao de papeis e usuarios.
- Consulta de logs.
- Componentes reutilizaveis para selects de sistema, modulo e perfil.
- Fluxos de formulario padronizados com selects pesquisaveis e linguagem consistente.
- Telas de autenticacao e administracao alinhadas ao tema global do backoffice, incluindo formularios, tabelas e modais.

## Rotas

Prefixo: seguranca

- resources: sistemas, modulos, funcionalidades, privilegios, papeis, usuarios, logs
- usuarios.validaLogin
- usuarios.atualizaSenha
- privilegios.destroydep

## ACL

- Middleware acl valida acesso por controller + action.
- Privilegios e dependencias determinam se rota pode ser executada.
- Toda mudanca em nome de action, rota adicional ou fluxo complementar deve ser refletida em privilegios e dependencias.

## Regras de Negocio

- Toda nova rota protegida deve ter privilegio correspondente.
- Dependencias devem cobrir acoes complementares (store/update etc.).
- Alteracoes em permissao precisam ser refletidas em seed e testes.
- Usuarios devem possuir ao menos um perfil associado nos fluxos de criacao/edicao.
- Funcionalidades devem possuir ao menos um privilegio quando editadas no fluxo administrativo.
- Modulos dependem da existencia de sistemas; papeis dependem da existencia de funcionalidades com privilegios.

## Padroes de Interface

- Selects reutilizaveis de sistema, modulo e perfil usam o padrao global `data-tom-select`.
- Telas de administracao devem manter mensagens e labels consistentes entre grid, modal e formulario.
- Modais de edicao devem ser compativeis com o evento global `modal:loaded` para inicializacao de componentes.
- Formularios de usuario, senha, sistemas e modulos devem aproveitar a camada global de UX para loading, foco visivel e consistencia de acoes.

## Testes Recomendados

- Acesso autorizado e nao autorizado por papel.
- Fluxos de usuario (senha, login, perfil).
- Integridade de vinculos papel x privilegio.
- Validacao de login disponivel/indisponivel.
- Integridade das dependencias de privilegio em funcionalidades.
