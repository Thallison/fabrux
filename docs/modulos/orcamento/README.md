# Modulo Orcamento

## Objetivo

Gerenciar a criacao, consulta, envio e exportacao de orcamentos comerciais com base em clientes e produtos cadastrados.

## Escopo Funcional

- Criar orcamento com multiplos itens.
- Selecionar cliente com busca no formulario.
- Selecionar cliente e status com padrao global de select pesquisavel quando aplicavel.
- Selecionar produtos por linha com select pesquisavel em vez de entrada textual livre.
- Carregar valor do produto automaticamente (com possibilidade de edicao manual no item).
- Aplicar desconto percentual no cabecalho do orcamento.
- Calcular subtotal, valor de desconto e total.
- Visualizar orcamento e detalhamento de itens.
- Duplicar orcamentos a partir da listagem e da tela de detalhes.
- Registrar historico de status do ciclo do orcamento.
- Gerar PDF para visualizacao e download.
- Enviar orcamento por e-mail com PDF anexado.
- Compartilhar orcamento por WhatsApp com link assinado para PDF publico.
- Configurar cabecalho de PDF (empresa que emite o orcamento).
- Filtrar listagem por texto, status, cliente, periodo de criacao e periodo de validade.

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
- GET orcamento/orcamentos/{id}/edit -> orcamento::orcamentos.edit
- PUT orcamento/orcamentos/{id} -> orcamento::orcamentos.update
- POST orcamento/orcamentos/{id}/duplicate -> orcamento::orcamentos.duplicate
- GET orcamento/orcamentos/{id} -> orcamento::orcamentos.show
- DELETE orcamento/orcamentos/{id} -> orcamento::orcamentos.destroy
- POST orcamento/orcamentos/{id}/status -> orcamento::orcamentos.update-status
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
- Editar Orcamentos (edit)
- Duplicar Orcamentos (duplicate)
- Excluir Orcamentos (destroy)
- Enviar Orcamentos (sendEmail)
- Alterar Status Orcamentos (updateStatus)
- Configurar Cabecalho Orcamentos (headerConfig)

Dependencias de privilegios:

- create -> store
- edit -> update
- show -> previewPdf, downloadPdf, redirectWhatsapp
- headerConfig -> saveHeaderConfig

## Transicoes de Status

Regras de transicao implementadas:

- Rascunho -> Enviado, Aprovado, Rejeitado, Expirado
- Enviado -> Aprovado, Rejeitado, Expirado
- Aprovado -> Expirado
- Rejeitado -> Rascunho, Enviado
- Expirado -> Rascunho, Enviado

Tentativas de transicao fora dessas regras sao bloqueadas por validacao.

## Historico de Status

Tabela dedicada:

- orc_status_historicos
	- orc_id
	- usr_id
	- osh_status_anterior
	- osh_status_novo
	- osh_motivo
	- timestamps

Eventos registrados:

- criacao do orcamento (status inicial)
- alteracao manual de status
- envio por e-mail (status Enviado)
- envio por WhatsApp (status Enviado)
- duplicacao (status inicial do novo orcamento)

## Padroes de Interface

- Campo de cliente com busca na criacao/edicao.
- Filtros de listagem com select pesquisavel para cliente e status.
- Itens do orcamento com select pesquisavel de produto por linha, aberto de forma visivel fora do overflow da tabela.
- Campos de data com abertura direta do calendario nativo do navegador.
- Tela de detalhes com troca de status, duplicacao e historico na mesma pagina.
- Grupos de botoes de acao alinhados a direita no desktop em listagem e detalhe.
- Botoes com icone e texto usando espacamento visual consistente (icone com `me-1`).
- Textos e labels padronizados em portugues tecnico consistente com PDF e acoes da UI.

## Regras de Negocio

- Validade deve ser maior ou igual a data de criacao.
- Orcamento deve possuir pelo menos 1 item.
- Um mesmo produto nao pode ser repetido em mais de uma linha do mesmo orcamento.
- O item so pode referenciar produto existente e ativo carregado no formulario.
- Quantidade e valor unitario sao validados com suporte a formato decimal pt-BR.
- Desconto percentual e limitado entre 0 e 100.
- Total do item = quantidade x valor unitario.
- Subtotal = soma dos totais de itens.
- Valor de desconto = subtotal x (desconto percentual / 100).
- Total final = subtotal - valor de desconto.
- Numero de orcamento no formato ORC-ANO-SEQUENCIAL.
- Status inicial: Rascunho.
- Ao enviar por e-mail ou WhatsApp, status e atualizado para Enviado.
- Link publico assinado do PDF expira no fim da validade do orçamento.
- Se o orçamento ja estiver vencido, o envio por WhatsApp usa link de contingencia com duracao de 24 horas.

## Fluxo de Uso

1. Acessar lista de orcamentos.
	- Opcionalmente filtrar por texto, status, cliente, periodo de criacao e periodo de validade.
2. Abrir Novo Orcamento.
3. Selecionar cliente e preencher datas.
4. Adicionar itens escolhendo produtos na busca da linha e ajustar valores quando necessario.
5. Definir desconto percentual.
6. Salvar orcamento.
7. Ajustar itens e dados pelo fluxo de edicao quando necessario.
8. Atualizar status (Rascunho, Enviado, Aprovado, Rejeitado, Expirado).
9. Visualizar, baixar PDF e enviar para o cliente.
10. Ajustar cabecalho do PDF em Configuracoes quando necessario.

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

Compilar assets quando houver mudanca de frontend:

- npm run build
- ou, em Windows/Laragon sem node no PATH:
- D:\laragon\bin\nodejs\node-v22\node.exe node_modules\vite\bin\vite.js build

## Riscos e Pontos de Atencao

- Alteracoes em actions de controller exigem ajuste de ACL (privilegios e dependencias).
- Mudancas em formato de moeda/quantidade devem manter compatibilidade com normalizacao no backend.
- Envio por e-mail depende da configuracao de mailer no ambiente.
- Compartilhamento por WhatsApp depende de telefone valido no cadastro do cliente.
- Link assinado do PDF publico possui expiração e nao deve ser usado como URL permanente.

## Checklist de Evolucao Recomendada

- Criar testes de feature para create, duplicate, updateStatus, sendEmail e ACL.
- Registrar visualizacao publica do PDF em trilha de auditoria quando isso virar requisito funcional.
- Avaliar politica de bloqueio para exclusao de orcamentos enviados/aprovados.
- Formalizar contrato de templates PDF por empresa/unidade quando o cabecalho evoluir.
