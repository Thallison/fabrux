# Modulo Orcamento

## Objetivo

Gerenciar a criacao, consulta, envio e exportacao de orcamentos comerciais com base em clientes e produtos cadastrados.

## Escopo Funcional

- Criar orcamento com multiplos itens.
- Selecionar cliente com busca no formulario.
- Carregar valor do produto automaticamente (com possibilidade de edicao manual no item).
- Aplicar desconto percentual no cabecalho do orcamento.
- Calcular subtotal, valor de desconto e total.
- Visualizar orcamento e detalhamento de itens.
- Gerar PDF para visualizacao e download.
- Enviar orcamento por e-mail com PDF anexado.
- Compartilhar orcamento por WhatsApp com link assinado para PDF publico.
- Configurar cabecalho de PDF (empresa que emite o orcamento).

## Entidades e Tabelas

### orc_orcamentos

- orc_id (PK)
- orc_numero (unico)
- cli_id (FK para cad_clientes)
- orc_data_emissao
- orc_data_validade
- orc_desconto_percentual
- orc_subtotal
- orc_valor_desconto
- orc_total
- orc_status
- orc_observacoes

### orc_orcamento_itens

- oci_id (PK)
- orc_id (FK para orc_orcamentos)
- prod_id (FK para cad_produtos)
- oci_produto_codigo
- oci_produto_nome
- oci_quantidade
- oci_valor_unitario
- oci_total

### orc_cabecalhos

- orc_cab_id (PK)
- orc_cab_nome
- orc_cab_documento
- orc_cab_endereco
- orc_cab_telefone
- orc_cab_email
- orc_cab_site
- orc_cab_rodape

## Rotas Web

Prefixo: orcamento

Middleware principal: auth, verified, acl

- GET orcamento/orcamentos -> orcamento::orcamentos.index
- GET orcamento/orcamentos/create -> orcamento::orcamentos.create
- POST orcamento/orcamentos -> orcamento::orcamentos.store
- GET orcamento/orcamentos/{id} -> orcamento::orcamentos.show
- DELETE orcamento/orcamentos/{id} -> orcamento::orcamentos.destroy
- GET orcamento/orcamentos/{id}/pdf -> orcamento::orcamentos.preview-pdf
- GET orcamento/orcamentos/{id}/pdf/download -> orcamento::orcamentos.download-pdf
- POST orcamento/orcamentos/{id}/send-email -> orcamento::orcamentos.send-email
- GET orcamento/orcamentos/{id}/send-whatsapp -> orcamento::orcamentos.send-whatsapp
- GET orcamento/configuracoes/cabecalho -> orcamento::orcamentos.header-config
- POST orcamento/configuracoes/cabecalho -> orcamento::orcamentos.header-config.save

Rota publica com assinatura:

- GET orcamento/orcamentos/publico/{id}/pdf -> orcamento::orcamentos.public-pdf (middleware signed)

## Permissoes ACL

Funcionalidade principal registrada:

- Controller: Modules\\Orcamento\\Http\\Controllers\\OrcamentosController
- Label: Orcamentos
- Rota padrao: orcamento::orcamentos.index

Privilegios cadastrados:

- Listar Orcamentos (index)
- Cadastrar Orcamentos (create)
- Visualizar Orcamentos (show)
- Excluir Orcamentos (destroy)
- Enviar Orcamentos (sendEmail)
- Configurar Cabecalho Orcamentos (headerConfig)

Dependencias de privilegios:

- create -> store
- show -> previewPdf, downloadPdf, redirectWhatsapp
- headerConfig -> saveHeaderConfig

## Regras de Negocio

- Validade deve ser maior ou igual a data de criacao.
- Orcamento deve possuir pelo menos 1 item.
- Quantidade e valor unitario sao validados com suporte a formato decimal pt-BR.
- Desconto percentual e limitado entre 0 e 100.
- Total do item = quantidade x valor unitario.
- Subtotal = soma dos totais de itens.
- Valor de desconto = subtotal x (desconto percentual / 100).
- Total final = subtotal - valor de desconto.
- Numero de orcamento no formato ORC-ANO-SEQUENCIAL.
- Status inicial: Rascunho.
- Ao enviar por e-mail ou WhatsApp, status e atualizado para Enviado.

## Fluxo de Uso

1. Acessar lista de orcamentos.
2. Abrir Novo Orcamento.
3. Selecionar cliente e preencher datas.
4. Adicionar itens e ajustar valores quando necessario.
5. Definir desconto percentual.
6. Salvar orcamento.
7. Visualizar, baixar PDF e enviar para o cliente.
8. Ajustar cabecalho do PDF em Configuracoes quando necessario.

## Arquivos Principais do Modulo

- Modules/Orcamento/routes/web.php
- Modules/Orcamento/routes/api.php
- Modules/Orcamento/app/Http/Controllers/OrcamentosController.php
- Modules/Orcamento/app/Http/Requests/StoreOrcamentoRequest.php
- Modules/Orcamento/app/Http/Requests/UpdateCabecalhoOrcamentoRequest.php
- Modules/Orcamento/app/Models/Orcamento.php
- Modules/Orcamento/app/Models/OrcamentoItem.php
- Modules/Orcamento/app/Models/OrcamentoCabecalho.php
- Modules/Orcamento/resources/views/orcamentos/index.blade.php
- Modules/Orcamento/resources/views/orcamentos/create.blade.php
- Modules/Orcamento/resources/views/orcamentos/show.blade.php
- Modules/Orcamento/resources/views/orcamentos/header-config.blade.php
- Modules/Orcamento/resources/views/pdf/orcamento.blade.php
- Modules/Orcamento/database/seeders/CreateFuncionalidadeMenuSeeder.php

## Operacao e Comandos

Aplicar migrations do modulo:

- php artisan migrate --path=Modules/Orcamento/database/migrations

Semear funcionalidades/permissoes:

- php artisan db:seed --class="Modules\\Orcamento\\Database\\Seeders\\OrcamentoDatabaseSeeder"

Limpar e recompilar caches apos mudancas em view/rotas:

- php artisan optimize:clear
- php artisan view:cache

## Riscos e Pontos de Atencao

- Alteracoes em actions de controller exigem ajuste de ACL (privilegios e dependencias).
- Mudancas em formato de moeda/quantidade devem manter compatibilidade com normalizacao no backend.
- Envio por e-mail depende da configuracao de mailer no ambiente.
- Compartilhamento por WhatsApp depende de telefone valido no cadastro do cliente.
- Link assinado do PDF publico possui expiração e nao deve ser usado como URL permanente.

## Checklist de Evolucao Recomendada

- Implementar edicao de orcamento (update de cabecalho e itens).
- Adicionar status Aprovado, Rejeitado e Expirado.
- Registrar trilha de auditoria de envio e visualizacao publica.
- Criar testes de feature para create, sendEmail, previewPdf e ACL.
- Adicionar politica de bloqueio para exclusao de orcamentos enviados/aprovados.
