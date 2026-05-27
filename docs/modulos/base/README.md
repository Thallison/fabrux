# Modulo Base

## Objetivo

Fornecer infraestrutura comum reutilizada por todos os modulos.

## Componentes Principais

- BaseController: CRUD padrao, validacao, retorno de views/json.
- BaseModel: busca para grids e comportamentos comuns de entidade.
- CepController e recursos utilitarios de suporte.

## Regras e Convencoes

- Controllers de modulo devem herdar comportamentos do BaseController quando aplicavel.
- Models de modulo devem seguir padrao de rules() e atribbutesLabel().
- Rotas utilitarias compartilhadas ficam neste modulo.

## Uso no Projeto

- Cadastros, Producao, Relatorios e Seguranca dependem desse modulo para reduzir duplicacao.

## Riscos

- Mudancas em BaseController/BaseModel afetam multiplos modulos.
- Qualquer alteracao deve ser validada por testes de regressao.
