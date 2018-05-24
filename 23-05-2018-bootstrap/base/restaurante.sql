create database restaurante_tads;
use restaurante_tads;

create table cidades (
	cod_cidade int not null auto_increment primary key,
	nome varchar(100) not null,
	uf char(2) not null
);

create table clientes (
	cod_cliente int not null auto_increment primary key,
	nome varchar(100) not null,
	cpf char(11),
	rg char(16),
	telefone varchar(20),
	celular varchar(20),
	email varchar(150),
	rua varchar(200),
	bairro varchar(100),
	cod_cidade int,
	cep char(8),
	data_nascimento datetime,
	renda_familiar float,
	conheceu_por_jornais char(1),
	conheceu_por_internet char(1),
	conheceu_por_outro char(1),
	sexo char(1),
	constraint fk_cli_cid foreign key (cod_cidade) references cidades (cod_cidade)
);

/*
alter table clientes add conheceu_por_jornais char(1);
alter table clientes add conheceu_por_internet char(1);
alter table clientes add conheceu_por_outro char(1);
alter table clientes add sexo char(1);
*/

insert into cidades (nome, uf) values ('Adamantina','SP');
insert into cidades (nome, uf) values ('Lucélia','SP');
insert into cidades (nome, uf) values ('Flórida Paulista','SP');
insert into cidades (nome, uf) values ('Uberlândia','MG');
insert into cidades (nome, uf) values ('Curitiba','PR');


create table encomendas (
	num_encomenda int not null auto_increment primary key,
	cod_cliente int not null,
	data datetime not null,
	valor_total float,
	constraint fk_cli_enc foreign key (cod_cliente) references clientes (cod_cliente)
);

create table categorias (
	cod_categoria int not null auto_increment primary key,	
	descricao varchar(100) not null
);

create table pratos (
	cod_prato int not null auto_increment primary key,
	descricao varchar(100) not null,
	valor_unitario float,
	cod_categoria int not null,
	constraint fk_pra_cat foreign key (cod_categoria) references categorias (cod_categoria)
);

create table itens_encomenda (
	cod_item_encomenda int not null auto_increment primary key,
	num_encomenda int not null,
	cod_prato int not null, 
	quantidade float not null,
	valor_unitario float not null,
	constraint fk_it_enc foreign key (num_encomenda) references encomendas (num_encomenda),
	constraint fk_it_pra foreign key (cod_prato) references pratos (cod_prato)
);

create table unidades (
	cod_unidade	int not null auto_increment primary key,
	descricao	varchar(100) not null
);

create table ingredientes (
	cod_ingrediente	int not null auto_increment primary key,
	descricao	varchar(100) not null,
	valor_unitario	float,
	cod_unidade	int not null,
	constraint fk_ing_uni  foreign key (cod_unidade) references unidades (cod_unidade)
);

create table composicao (
	cod_prato int not null,
	cod_ingrediente int not null,
	qde	float not null,
	constraint fk_comp_pra foreign key (cod_prato) references pratos (cod_prato), 
	constraint fk_comp_ing foreign key (cod_ingrediente) references ingredientes (cod_ingrediente),
	constraint pk_comp primary key (cod_prato, cod_ingrediente)
);


create table fornecedores (
	cod_fornecedor int not null auto_increment primary key,
	razao_social varchar(100) not null,
	nome_fantasia varchar(100) not null,
	cnpj char(16),
	inscricao_estadual varchar(18),
	endereco varchar(100),
	bairro varchar(100),
	cod_cidade int,
	cep char(8),
	telefone varchar(15),
	celular varchar(15),
	email varchar(150),
	constraint fk_for_cid foreign key (cod_cidade) references cidades (cod_cidade)
);

create table compras (
	cod_compra int not null auto_increment primary key,
	nota_fiscal int not null,
	data datetime not null,
	cod_fornecedor int not null,
	valor_total float,
	nota_serie int,
	constraint fk_compras_for foreign key (cod_fornecedor) references fornecedores (cod_fornecedor)
);

create table itens_compra (
	cod_item_compra int not null auto_increment primary key,
	cod_compra int not null,
	cod_ingrediente int not null,
	qde float not null default 0,
	valor_unitario float not null default 0,
	constraint fk_it_comp_comp foreign key (cod_compra) references compras (cod_compra),
	constraint fk_it_comp_ing foreign key (cod_ingrediente) references ingredientes (cod_ingrediente)
);

insert into categorias (descricao) values ('Porção');
insert into categorias (descricao) values ('Prato Feito');
insert into categorias (descricao) values ('Bebida');
insert into categorias (descricao) values ('Lanche');
insert into categorias (descricao) values ('Pizza');

-- select * from unidades
insert into unidades (descricao) values ('kg');
insert into unidades (descricao) values ('Lata');
insert into unidades (descricao) values ('Unidade');


-- select * from ingredientes
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Massa para Lasanha',1.8,3);
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Presunto',15,1);
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Massa de Tomate',2.75,2);
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Feijao Preto',3,1);
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Calabresa',13,1);
insert into ingredientes (descricao, valor_unitario, cod_unidade) values ('Mussarela',25,1);


insert into pratos (descricao, valor_unitario, cod_categoria) values ('Lasanha',50,2);
insert into pratos (descricao, valor_unitario, cod_categoria) values ('X Tudo',38,4);
insert into pratos (descricao, valor_unitario, cod_categoria) values ('Pizza Calabresa',77,5);
insert into pratos (descricao, valor_unitario, cod_categoria) values ('Feijoada',90,2);


insert into composicao (cod_prato, cod_ingrediente, qde) values ('4', '3', '1');



create table usuarios (
	cod_usuario int not null auto_increment primary key,
	nome_completo varchar(100),
	login varchar(30),
	senha varchar(100)
);

insert into usuarios (nome_completo,login,senha) 

values ('André Mendes','andre',MD5('123'));







