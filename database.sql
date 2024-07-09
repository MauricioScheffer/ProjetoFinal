create database bdSocial;

use bdSocial;

create table Usuario(
id int auto_increment primary key,
nome varchar(255) not null,
apelido varchar(16) not null unique,
email varchar(100) not null unique,
telefone varchar(15),
sexo char(1),
senha varchar(255) not null,
foto varchar(255),
nascimento date not null,
adm boolean,
ativo boolean default 1
);

create table Seguidor(
id int auto_increment primary key,
idUsuario int not null,
idSeguidor int not null
);

ALTER TABLE Seguidor
ADD CONSTRAINT fk_idUsuario FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE;

ALTER TABLE Seguidor
ADD CONSTRAINT fk_idSeguidor FOREIGN KEY (idSeguidor) REFERENCES Usuario(id) ON DELETE CASCADE;

create table Postagem(
id int auto_increment primary key,
idUsuario int not null,
titulo varchar(100) not null,
descricao varchar(500) not null,
imagem varchar(255),
data date not null
);

ALTER TABLE Postagem
ADD CONSTRAINT fk_idUsuario_POST FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE;

create table Curtida(
id int auto_increment primary key,
idPostagem int not null,
idUsuario int not null
);

ALTER TABLE Curtida
ADD CONSTRAINT fk_idPostagem FOREIGN KEY (idPostagem) REFERENCES Postagem(id) ON DELETE CASCADE;

ALTER TABLE Curtida
ADD CONSTRAINT fk_idUsuario_Curtida FOREIGN KEY (idUsuario) REFERENCES Postagem(id) ON DELETE CASCADE;

Create table Comentario(
id int auto_increment primary key,
idPostagem int not null,
idUsuario int not null,
descricao varchar(255) not null,
data date not null
);

ALTER TABLE Curtida
DROP FOREIGN KEY fk_idUsuario_Curtida;

ALTER TABLE Curtida
ADD CONSTRAINT fk_idUsuario_Curtida FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE;

ALTER TABLE Comentario
ADD CONSTRAINT fk_idPostagem_Comentario FOREIGN KEY (idPostagem) REFERENCES Postagem(id) ON DELETE CASCADE;

ALTER TABLE Comentario
ADD CONSTRAINT fk_idUsuario_Comentario FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE;

Update Usuario set adm = 1 where id = 1;