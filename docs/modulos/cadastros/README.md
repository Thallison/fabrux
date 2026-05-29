# Modulo Cadastros

## Objetivo

Gerenciar entidades mestres usadas por outros fluxos: funcionarios, produtos e clientes.

## Funcionalidades

- CRUD de funcionarios.
- CRUD de produtos.
- CRUD de clientes.
- Busca de CEP com preenchimento automatico de endereco no cadastro de clientes.
- Formularios com padrao visual unificado e selects de status com componente pesquisavel.
- Listagens e formularios alinhados ao tema global do backoffice, com foco em consistencia entre grids, acoes e feedback visual.

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
- Clientes suportam mascara e validacao de CPF/CNPJ conforme tipo de pessoa.
- Busca de CEP deve preencher logradouro, bairro, cidade e estado quando o endpoint responder com sucesso.
- Selects de status usam o padrao global documentado em docs/padroes-frontend.md.
- Formularios devem preferir a camada global de UX para loading, validacao visual e consistencia de estrutura.

## Experiencia de Uso

- Clientes: formulario completo com validacao progressiva, mascara, CEP e status.
- Funcionarios: cadastro e edicao via modal com status padronizado.
- Produtos: cadastro e edicao via modal com status padronizado e valor monetario formatado.
- As listagens usam acabamento compartilhado para toolbar, empty state, paginacao e botoes de acao.

## Testes Recomendados

- Fluxo CRUD completo por entidade.
- Validacoes obrigatorias e unicidade.
- Comportamento de acoes de grid (editar/excluir).
- CEP: resposta bem-sucedida, CEP invalido e falha de consulta.
- Clientes: validacao de CPF/CNPJ por tipo de pessoa.
