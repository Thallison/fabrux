# Modulo Relatorios

## Objetivo

Disponibilizar visoes analiticas para suporte a decisao operacional e gerencial.

## Funcionalidades

- Relatorio de producao diaria.
- Relatorio de produtividade por funcionario.
- Relatorio de producao por produto.
- Comparativo.
- Projecao.
- Todos os relatorios web seguem padrao visual unificado com cards analiticos, filtros consistentes e KPI boxes compartilhados com o dashboard de producao.

## Rotas

Prefixo: relatorios

- relatorios.index (resource)
- producao.diaria
- produtividade.funcionario
- producao.produto
- comparativo
- projecao

## Permissoes

- ACL obrigatoria para acesso aos endpoints de relatorio.
- Privilegios por acao especifica no seeder do modulo.

## Regras de Negocio

- Consultas devem refletir dados de producao com filtros consistentes.
- Nomes de rotas e acoes precisam manter compatibilidade com privilegios.
- Relatorios com resumo numerico devem reutilizar `fabrux-kpi-box` sempre que houver indicadores principais no topo da tela.
- Cards de tabela e graficos devem manter subtitulo contextual para facilitar leitura gerencial.

## Testes Recomendados

- Acesso com e sem permissao.
- Integridade dos filtros e retorno esperado.
