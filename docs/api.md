# API e Endpoints

## Objetivo

Mapear endpoints relevantes para integracoes e uso interno.

## Endpoints Publicos Relevantes

### CEP

- GET /api/cep/buscar?cep={cep}
- Origem: modulo Base (CepController)
- Uso: preenchimento automatico de endereco em formularios.

## Endpoints Modulares (Web)

As rotas principais dos modulos estao em:

- Modules/Cadastros/routes/web.php
- Modules/Producao/routes/web.php
- Modules/Relatorios/routes/web.php
- Modules/Seguranca/routes/web.php

## Padroes de Resposta

- Fluxos de CRUD podem responder com redirect + flash message.
- Acoes de exclusao e alguns fluxos de update podem responder JSON.

## Seguranca de Acesso

- Rotas modulares protegidas por auth/verified e, quando aplicavel, acl.

## Evolucao Recomendada

- Criar secao por modulo com tabela de endpoints e exemplos de payload.
- Definir contratos JSON para respostas padronizadas de erro/sucesso.
