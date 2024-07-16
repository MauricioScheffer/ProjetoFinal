
<?php

session_start();
include_once ('Classes/Database.php');
include_once ('Classes/Post.php');
include_once ('Classes/Usuario.php');
include_once ('Config/config.php');

$usuario = new Usuario($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Processar login
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            header('Location: index.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Logar</title>
</head>
<body>
<nav>
        <div class="container">
            <h2 class="log">
                Rede Social
            </h2>
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

            <div class="meio">
                <h2>Entrar</h2>
                <div class="caixas">
                    <input type="text" placeholder="E-mail">
                    <input type="password" id="senha" placeholder="Senha">
                    <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i>
                </div>
                <div class="botao">
                    <label class="btn btn-primary entrar" type="submit" value="login">Entrar</label>
                    <label class="btn btn-primary entrar">Cadastrar-se</label>
                </div>
                <a href="">Esqueci minha senha</a>
            </div>

        </div>
        <footer>
        <div class="container">
            <p>&copy; 2024 Rede Social. Todos os direitos reservados.</p>
        </div>
        </footer>

    </main>
</body>
<script src="Script/main.js"></script>
</html>