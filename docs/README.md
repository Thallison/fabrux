# Documentacao Fabrux

## Objetivo

Centralizar a documentacao funcional e tecnica do projeto para acelerar onboarding, manutencao e desenvolvimento assistido por IA.

## Mapa de Documentos

- arquitetura.md: visao arquitetural e diretrizes de evolucao.
- onboarding.md: setup e primeiros passos.
- contribuindo.md: fluxo de contribuicao e checklist de PR.
- guia-de-estilo.md: padroes de codigo e organizacao.
- padroes-frontend.md: convencoes de componentes de interface e JS reutilizavel.
- testes.md: estrategia e comandos de teste.
- ia-copilot.md: boas praticas para uso de Copilot.
- perguntas-frequentes.md: respostas operacionais comuns.
- organizacao-documentacao.md: convencoes para novas paginas.
- roadmap.md: planejamento evolutivo por horizonte.
- release-processo.md: fluxo padrao de release e rollback.
- observabilidade.md: guias de monitoracao e debug.
- seguranca-aplicacao.md: praticas e checklist de seguranca.
- api.md: visao de endpoints e contratos.
- modulos/README.md: indice de documentacao por modulo.
- adr/README.md: decisoes arquiteturais registradas.

## Como Usar Esta Documentacao

1. Comece por onboarding.md e arquitetura.md.
2. Consulte o README do modulo alvo em docs/modulos.
3. Ao alterar comportamento, atualize o documento correspondente.

## Navegacao Rapida por Persona

### Backend

1. [Arquitetura](docs/arquitetura.md)
2. [Guia de Estilo](docs/guia-de-estilo.md)
3. [Testes](docs/testes.md)
4. [Documentacao por Modulo](docs/modulos/README.md)
5. [Seguranca da Aplicacao](docs/seguranca-aplicacao.md)

### Frontend

1. [Documentacao por Modulo](docs/modulos/README.md)
2. [Guia de Estilo](docs/guia-de-estilo.md)
3. [Padroes Frontend](docs/padroes-frontend.md)
4. [API e Endpoints](docs/api.md)
5. [Perguntas Frequentes](docs/perguntas-frequentes.md)

### QA

1. [Testes](docs/testes.md)
2. [Observabilidade](docs/observabilidade.md)
3. [API e Endpoints](docs/api.md)
4. [Roadmap](docs/roadmap.md)

### Produto/Gestao

1. [Roadmap](docs/roadmap.md)
2. [Arquitetura](docs/arquitetura.md)
3. [Release](docs/release-processo.md)
4. [Documentacao por Modulo](docs/modulos/README.md)

### Copilot/IA

1. [Guia do Copilot](docs/ia-copilot.md)
2. [Organizacao da Documentacao](docs/organizacao-documentacao.md)
3. [Template de Modulo](docs/templates/modulo-template.md)
4. [Template de ADR](docs/templates/adr-template.md)

## Padrao Minimo por Feature

Toda feature relevante deve ter, no minimo:

- descricao funcional
- regras de negocio
- impacto em rotas/permissoes
- testes relacionados
- observacoes para IA/Copilot quando aplicavel

## Ultimas Convencoes Relevantes

- Selects pesquisaveis devem usar o padrao global documentado em padroes-frontend.md.
- Mudancas de modulo devem refletir o README correspondente em docs/modulos.
- Quando o ambiente nao expuser `node` no PATH, a documentacao deve registrar o comando alternativo usado pelo time.
- Mudancas de interface devem considerar a camada global de UX e tema compartilhado antes de adicionar CSS ou JS local por tela.
