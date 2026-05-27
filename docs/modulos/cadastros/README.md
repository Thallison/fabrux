# Modulo Cadastros

## Objetivo

Gerenciar entidades mestres usadas por outros fluxos: funcionarios, produtos e clientes.

## Funcionalidades

- CRUD de funcionarios.
- CRUD de produtos.
- CRUD de clientes.

## Rotas

Prefixo: cadastros

- resource funcionarios
- resource produtos
- resource clientes

Middleware: auth, verified, acl.

## Permissoes

Permissoes mapeadas por seed:

- Listar/Cadastrar/Editar/Excluir para cada recurso.
- Dependencias para acoes store/update conforme padrao de ACL.

## Regras de Negocio Relevantes

- Campos obrigatorios e unicidade definidos nas rules() dos models.
- Formularios devem seguir padrao visual dos cadastros existentes.
- Grids usam Bootstrap Table e formatters JS globais.

## Testes Recomendados

- Fluxo CRUD completo por entidade.
- Validacoes obrigatorias e unicidade.
- Comportamento de acoes de grid (editar/excluir).
