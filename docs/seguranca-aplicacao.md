# Seguranca da Aplicacao

## Objetivo

Registrar praticas e cuidados de seguranca aplicados no projeto.

## Controles Atuais

- Autenticacao via stack Laravel/Fortify.
- Autorizacao por ACL (papel, privilegio e dependencia).
- Rotas protegidas por middleware auth, verified e acl.
- Registro de logs para trilha de auditoria.

## Regras Operacionais

- Toda nova rota protegida deve ter privilegio correspondente.
- Acoes auxiliares (store/update etc.) devem ter dependencia cadastrada quando necessario.
- Alteracoes em permissao exigem teste de acesso autorizado e nao autorizado.

## Boas Praticas de Desenvolvimento

- Nao expor segredos no codigo.
- Validar entrada no backend, nao apenas no frontend.
- Evitar mensagens de erro com detalhes sensiveis.
- Revisar impacto de seeds de seguranca em ambiente com dados existentes.

## Checklist de Seguranca por Mudanca

- Mudou rota? Revisar middleware e privilegio.
- Mudou controller/action? Revisar dependencias ACL.
- Mudou fluxo de login/usuario? Revisar regressao em Seguranca.
- Mudou dados sensiveis? Revisar mascaramento e logs.
