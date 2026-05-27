# Observabilidade

## Objetivo

Garantir capacidade de diagnosticar comportamentos do sistema com rapidez, especialmente em fluxos de ACL e CRUD.

## Fontes de Sinal

- Logs de aplicacao Laravel.
- Canal de logs de acesso ACL.
- Erros de frontend (console/browser quando necessario).
- Resultado de testes automatizados.

## Eventos Importantes para Monitorar

- Falhas de validacao em endpoints de cadastro.
- Erros 403/401 em rotas protegidas por ACL.
- Excecoes em middlewares de seguranca.
- Erros de rota por parametro ausente.

## Diretrizes de Log

- Incluir contexto de usuario, rota e acao quando possivel.
- Evitar logs com dados sensiveis.
- Usar mensagens consistentes para facilitar busca.

## Playbook de Debug

1. Reproduzir erro com rota exata.
2. Verificar middleware aplicado na rota.
3. Confirmar privilegio e dependencia no seed.
4. Validar payload e rules() do model.
5. Confirmar comportamento via teste de feature.

## Melhorias Futuras

- Padronizar chaves estruturadas nos logs.
- Criar paineis de indicadores operacionais por modulo.
- Definir alertas para erros criticos recorrentes.
