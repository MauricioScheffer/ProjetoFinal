<?php
include_once('../Classes/Usuario.php');
include_once('../Config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $foto = "";
    $telefone = $_POST['telefone'];
    $nascimento = date($_POST['nascimento']);
    $sexo = $_POST['sexo'];
    $adm = 0;
    $ativo = 1;
    $usuario->criarUsuario($nome, $apelido, $email, $telefone, $sexo, $senha, $foto, $nascimento, $adm, $ativo);
    header('Location: login.php');
    exit();
}


?>














<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cadastrar</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    Rede Social
                </h2>
            </a>
            <!-- <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Pesquisar">
        </div> -->
            <div class="create">
                <a href="index.php"><label class="btn btn-primary" for="create-post">Voltar</label></a>
                <div class="profile-photo">
                    <img src="img/perfil.jpg" alt="">
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->
    <main>

        <div class="container">
            <form method="POST">
                <div class="meio">
                    <h2>Cadastrar</h2>
                    <div class="caixas">
                        <input type="text" name="nome" placeholder="Nome completo" required>
                        <input type="text" name="apelido" placeholder="Nome de usuário" required>
                        <!-- <input type="text" placeholder="Seu Pet🐶"> -->
                        <input type="email" name="email" placeholder="E-mail" required>

                        <input type="password" name="senha" id="senha" placeholder="Senha" required>
                        <input type="text" name="telefone" placeholder="Telefone" required>
                        <input type="date" name="nascimento" placeholder="Data de Nascimento" required>

                        <div class="sexo">
                            <label for="masculino">
                                <input type="radio" id="masculino" name="sexo" value="M" required> 
                            </label>
                            <label for="feminino">
                                <input type="radio" id="feminino" name="sexo" value="F" required> 
                            </label>
                            <label for="Outro">
                                <input type="radio" id="outro" name="sexo" value="O" required> 
                            </label>

                        </div>
                       
                        <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i>
                    </div>
                    <div class="botao">
                        <input class="btn btn-primary entrar" type="submit" value="Adicionar">
                    </div>
                </div>
            </form>
        </div>

    </main>
    <?php include 'footer.php'; ?>
    <script src="../Script/main.js"></script>
</body>

</html>