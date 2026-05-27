# Organizacao da Documentacao

## Estrutura Padrao Proposta

- docs/
  - README.md
  - arquitetura.md
  - onboarding.md
  - contribuindo.md
  - guia-de-estilo.md
  - testes.md
  - ia-copilot.md
  - perguntas-frequentes.md
  - organizacao-documentacao.md
  - roadmap.md
  - release-processo.md
  - observabilidade.md
  - seguranca-aplicacao.md
  - api.md
  - adr/
    - README.md
    - 0001-*.md
  - modulos/
    - README.md
    - <modulo>/README.md

## Convencao de Nomes

- Arquivos: lowercase com kebab-case.
- Idioma: portugues tecnico e objetivo.
- Modulos: usar o mesmo nome da pasta do modulo no projeto.

## Conteudo Minimo por Documento de Modulo

1. objetivo do modulo
2. responsabilidades
3. entidades principais
4. rotas e permissoes
5. regras de negocio
6. fluxo de uso
7. testes recomendados
8. pontos de extensao e riscos

## Boas Praticas

- Manter docs proximas da realidade do codigo (evitar texto generico).
- Atualizar docs no mesmo PR da mudanca funcional.
- Incluir exemplos de comandos quando houver operacao recorrente.
- Evitar duplicar informacao entre arquivos; prefira links cruzados.

## Integracao com IA

- Ao abrir tarefa com Copilot, informar modulo e documento-base.
- Referenciar explicitamente regras do modulo antes de pedir implementacao.
- Registrar decisoes importantes para reuso em proximas sessoes.
