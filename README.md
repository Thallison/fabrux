# Fabrux

## Sobre projeto base feito em Laravel

A ideia desse sistema é criar uma base simples para a implementação de outros sistemas utilizando o laravel. Versão atual 12
Foi desenvolvido todo o controle para login de usuário (autenticação), criação de sistemas, modulos, funcionalidades, privilegios e perfil de usuário, além da implementação basica de log.
Para este projeto foi utilizado o laravel modules [laravel modules](https://github.com/nWidart/laravel-modules) onde temos a pasta modules com dois modulos criados o Base e Seguranca.
A ideia é tratar tudo que for de utilização de todos ou seja a base de funcionamento do sistema como por exemplo controller base, model base, entre outros... no modulo Base.
O modulo Seguranca trata as questões de segurança do sistemas, que são cadastro de usuario, funcionalidade entre outros.


## Instalação do projeto

- Após realizar o clone do projeto necessário configurar o arquivo .env com as conexões do banco.
- Instalar e atualizar o projeto via composer, para que seja instalado as dependencias
- Instalar e atualizar o projeto com node (npm install) para que seja instalado as dependencias
- Executar as migration - php artisan module:migrate Seguranca
- Executar os seeds - php artisan module:seed Seguranca
- Por padrão já vem 1 usuário admin@email.com com a senha 123456


## Padrões para desenvolvimento

- Para criação de models, controller, utilizar os comandos de criação utilizando o [laravel modules](https://github.com/nWidart/laravel-modules)
- Toda controller deverá extender da controler base Modules, pois nele já foi implementado uma serie de funções e padrões para criação das telas => 'Modules\Base\Http\Controllers\BaseController'
- Toda entidade(model) deverá extender do model base, pois nele já foi implementado uma serie de funções e padrões para criação das telas => 'Modules\Base\Models\BaseModel'
- Para a listagem dos dados no grid o projeto está utilizando o [bootstrap-table](https://examples.bootstrap-table.com/)
- Toda Nome de controller e model criado deverão ser iguais e no plural 


Explicação de cada gráfico
1. Produção nos últimos 7 dias
Tipo: gráfico de linha
O que mostra: quantidade total de peças produzidas em cada dia dos últimos 7 dias
Para que serve: identifica tendência de alta/baixa no curto prazo e mostra se a produção está consistente ou caiu em dias recentes
2. Produção por hora
Tipo: gráfico de barras
O que mostra: quantidade produzida em cada hora do dia (0h a 23h), com base nos registros que têm produ_hora
Para que serve: revela quais turnos ou horários são mais produtivos e onde há perda de ritmo durante o dia
3. Produção mensal
Tipo: gráfico de barras
O que mostra: quantidade total produzida em cada mês dos últimos 6 meses
Para que serve: compara a evolução da produção mensal, ajuda a detectar sazonalidade e avaliar se o desempenho geral está melhorando ou piorando
4. Projeção do mês
Não é um gráfico, mas é um painel importante
O que calcula: média diária do mês atual e usa esse valor para estimar a produção até o final do mês
Para que serve: dá uma previsão rápida de “onde chegaremos se mantivermos o ritmo atual”
5. Tabela de eficiência de funcionários
Também não é gráfico, mas é um indicador chave
O que mostra: para cada funcionário com tempo registrado, a produção total, a taxa de produção por hora e o tempo médio por peça
Para que serve: identifica quem está mais eficiente e quem está demorando mais por unidade produzida
6. Ranking de hoje
Também é um componente de lista
O que mostra: os funcionários com maior quantidade produzida no dia
Para que serve: destaca quem está liderando a produção no dia e quem está abaixo do esperado
Esses gráficos juntos fornecem:

visão imediata do dia atual (Principal)
análise de ritmo horário (Ritmo)
visão de tendência e comparação (Comparativo)
projeção de meta mensal (Projeção)