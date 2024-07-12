<?php
session_start();
include_once ('../Config/config.php');
include_once ('../Classes/Usuario.php');
$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $senha = $_POST['senha'];


        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            if ($dados_usuario['ativo'] == 1) {
                header('Location: index.php');
                exit();
            }else{
                $mensagem_erro = "Conta inativada";
            }
        } else {
            $mensagem_erro = "Credenciais inválidas";
        }

    }


}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Logar</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    Rede Social
                </h2>
            </a>
            <div class="create">
                <a href="index.php"><label class="btn btn-primary" for="backButton">Voltar</label></a>
            </div>
        </div>
    </nav>

    <!-- main -->
    <main>
        <div class="container">
            <form method="POST">
                <div class="meio">
                    <h2>Entrar</h2>
                    <div class="caixas">
                        <input type="text" placeholder="E-mail" name="email" required>
                        <div class="senha">
                            <input type="password" id="senha" placeholder="Senha" name="senha" required>
                            <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i>
                        </div>
                    </div>
                    <div class="botao">
                        <input class="btn btn-primary entrar" type="submit" name="login" value="Entrar">
                        <a href="cadastro.php"><label class="btn btn-primary entrar">Cadastrar-se</label></a>
                    </div>

                    <div class="mensagem">
                        <?php if (isset($mensagem_erro))
                            echo '<p>' . $mensagem_erro . '</p>'; ?>
                    </div>
                    <a class="esqueci" href="">Esqueci minha senha</a>
                </div>
            </form>
        </div>

    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Rede Social. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
<script src="../Script/main.js"></script>

</html>