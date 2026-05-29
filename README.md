
# Fabrux

Base Laravel 12 para um sistema MES modular com ACL, cadastros mestres, producao, orcamentos e operacao assistida por componentes reutilizaveis.

## Índice

- [Visão Geral](#visão-geral)
- [Instalação](#instalação)
- [Uso](#uso)
- [Documentação](#documentação)
- [Contribuindo](#contribuindo)
- [Testes](#testes)
- [Licença](#licença)

## Visão Geral

Este sistema serve como base para implementacao de sistemas modulares em Laravel 12, ja incluindo autenticacao, controle de modulos, funcionalidades, privilegios, perfis de usuario e log basico.

O frontend do backoffice foi padronizado com uma camada visual compartilhada para layout, formularios, tabelas, dashboards e relatorios, reduzindo divergencia entre modulos e facilitando evolucao incremental da interface.

Utiliza [laravel-modules](https://github.com/nWidart/laravel-modules) para modularização. Os módulos principais são:
- **Base**: funcionalidades comuns e reutilizáveis (controller/model base, helpers, etc.)
- **Seguranca**: autenticação, cadastro de usuários, permissões, etc.
- **Cadastros**: funcionarios, produtos e clientes usados pelos demais fluxos.
- **Producao**: registro operacional e acompanhamento da producao.
- **Orcamento**: orcamentos comerciais com PDF, duplicacao, historico de status e envio.

## Instalação

1. Clone o repositório.
2. Configure o `.env` com as conexões do banco.
3. Instale dependências PHP: `composer install`
4. Instale dependências JS: `npm install`
5. Execute as migrations: `php artisan module:migrate Seguranca`
6. Execute os seeds: `php artisan module:seed Seguranca`
7. Usuário padrão: `admin@email.com` / senha: `123456`

## Uso

Rode o servidor local:

```
php artisan serve
```

Para assets frontend, use um destes fluxos:

```
npm run dev
```

ou:

```
npm run build
```

Em ambientes Windows/Laragon onde `node` ou `npm` nao estiverem no PATH global, use o executavel local do Node.js. Exemplo:

```
D:\laragon\bin\nodejs\node-v22\node.exe node_modules\vite\bin\vite.js build
```

## Documentação

Veja a pasta [docs/](docs/) para:
- Arquitetura do sistema
- Padroes frontend e componentes JS
- Guia de contribuição
- Guia de estilo
- Onboarding
- Testes
- FAQ
- Uso do GitHub Copilot

## Contribuindo

Consulte [docs/contribuindo.md](docs/contribuindo.md).

## Testes

Como rodar os testes:

```
php artisan test --compact
```

Mais detalhes em [docs/testes.md](docs/testes.md).

Para mudancas de interface que dependam de assets, valide tambem com:

```
D:\laragon\bin\nodejs\node-v22\node.exe node_modules\vite\bin\vite.js build
```

## Licença

Veja [LICENSE.md](LICENSE.md).