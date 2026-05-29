# Onboarding de Novos Desenvolvedores

## Objetivo

Permitir que uma pessoa nova no projeto rode o sistema localmente e entregue mudancas com seguranca no primeiro dia.

## Setup Inicial

1. Clonar repositorio.
2. Instalar dependencias:
	- composer install
	- npm install
3. Configurar ambiente:
	- copiar .env.example para .env
	- ajustar variaveis locais
4. Preparar app:
	- php artisan key:generate
	- php artisan migrate
	- php artisan db:seed (quando necessario)
5. Assets:
	- npm run dev (desenvolvimento)
	- npm run build (producao/local final)
	- se `node` ou `npm` nao estiverem no PATH no Windows/Laragon, usar o binario local do Node.js
	- exemplo: `D:\laragon\bin\nodejs\node-v22\node.exe node_modules\vite\bin\vite.js build`

## Primeiros Passos no Codigo

1. Ler arquitetura.md
2. Ler docs/modulos/README.md
3. Ler README do modulo em que vai atuar
4. Ler padroes-frontend.md quando houver telas, componentes ou JS envolvidos
5. Executar testes basicos:
	- php artisan test --compact

## Fluxo Diario Recomendado

1. Criar branch de trabalho.
2. Implementar mudanca pequena.
3. Rodar testes relacionados.
4. Rodar Pint.
5. Atualizar documentacao do modulo se houver mudanca funcional.

## Onde Buscar Informacao

- FAQ: perguntas-frequentes.md
- Testes: testes.md
- Contribuicao: contribuindo.md
- Copilot e IA: ia-copilot.md

## Checklist de Entrada

- Ambiente sobe sem erro.
- Rotas principais carregam.
- Permissoes de teste estao funcionando.
- Entende onde ficam rotas, views, models e seeds do modulo alvo.
- Sabe como compilar assets mesmo quando o ambiente local nao expoe `node` no PATH.
