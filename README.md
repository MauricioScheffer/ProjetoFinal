<!-- Nome do Projeto -->
Rede Social -> PetHub
<!-- Descrição -->
A Rede Social "PetHub" é a rede ideal para quem quer compartilhar suas experiências incríveis com seu animal de estimação. Você poderá criar uma conta e cadastrar seus pets, que aparecerão em seu perfil como pertecentes a você, além de poder registrar quantos pets você desejar. E não é só isso! Você poderá ver postagens de outros donos de pets, tendo a opção de curtir suas postagens, comentá-las, e até mesmo seguir quem você quiser, além de também poder ser seguido. Caso ocorra qualquer coisa, você poderá editar o cadastro do seu pet, ou até mesmo excluí-lo se desejar.

<!-- Funcionalidades -->
Criação/Personalização de Perfil
Criação/Edição de Publicação


<!-- Tecnologias Utilizadas: -->
PHP 
HTML
CSS
MySQL
JavaScript
<!-- Estrutura do Projeto -->
```plaintext





Projeto Final/
├── bdSocial/
│ ├── Usuario.sql
│ ├── Postagem.sql
│ ├── Seguidor.sql
│ ├── Comentario.sql
│ ├── Curtida.sql
├── css/
│ ├── styles.css
| ├── login.css

├── js/
│ ├── script.js

├── Classes/
│ ├── Database.php
│ ├── Usuario.php
│ ├── Postagem.php
│ ├── Comentario.php
│ ├── Segudidor.php
│ ├── Curtida.php
├── Config/
│ ├── Condig.php
├── index.php
├── login.php
├── logout.php
├── cadastro.php
├── deletar_usuario.php
├── editar_usuario.php
├── criar_postagem.php
├── editar_postagem.php
├── deletar_postagem.php
├── curtir_postagem.php
├── comentario.php
├── deletar_comentario.php
├── editar_comentario.php

├── [Usuario]/ <-- Usuario
│ ├── id
│ ├── nome
│ ├── apelido
│ ├── email
│ ├── telefone
│ ├── sexo
│ ├── senha
│ ├── foto
│ ├── nascimento
│ ├── adm
│ ├── ativo

├── [Postagem]/ <-- POST
│ ├── id 
│ ├── idUsuario
│ ├── titulo
│ ├── descricao
│ ├── imagem
│ ├── data


├── [Comentario]/ 
│ ├── id
│ ├── idPostagem
│ ├── idUsuario
│ ├── descricao
│ ├── data


├── [Seguidor]/ 
│ ├── id
│ ├── idUsuario
│ ├── idSeguidor


├── [Curtida]/ 
│ ├── id
│ ├── idPostagem
│ ├── idUsuario



└── README.md
```
<!-- Tabela relacional do banco utilizado no projeto -->

![Tabela relacional do banco de dados do projeto](https://github.com/MauricioScheffer/ProjetoFinal/assets/134110747/0fb8da46-f9f1-4654-81d3-4531ba6e2a3c)

