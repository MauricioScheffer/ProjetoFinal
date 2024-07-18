<?php
include_once ('Classes/Usuario.php');
include_once ('Config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sexo']) && $_POST['sexo'] !== "null") {
        $usuario = new Usuario($db);
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $foto = "img/default.jpg"; // foto de perfil padrão
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];
        $sexo = $_POST['sexo'];
        $adm = 0;
        $ativo = 1;

        $result = $usuario->criarUsuario($nome, $apelido, $email, $telefone, $sexo, $senha, $foto, $nascimento, $adm, $ativo);

        if ($result !== true) {
            echo '<script>
                window.onload = function() {
                    alert("' . addslashes($result) . '");
                }
            </script>';
        } else {
            header('Location: login.php');
            exit();
        }
    } else {
        echo '<script>
            window.onload = function() {
                alert("Informe um gênero!");
            }
        </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cadastrar</title>
</head>

<body>
    <nav>
        <div class="container">
            <div class="logo-container">
            <a href="index.php">
                <h2 class="log">
                    <img src="img/LogoWhite.png" alt="">
                </h2>
            </a>
                <a href="index.php"><label class="btn btn-primary" for="create-post">Voltar</label></a>
                </div>
        </div>
    </nav>

    <main>
        <div class="container">
            <form method="POST">
                <div class="meio">
                    <h2>Cadastrar</h2>
                    <div class="caixas">
                        <input type="text" name="nome" placeholder="Nome completo" required>
                        <input type="text" name="apelido" placeholder="Nome de usuário" required>
                        <input type="email" name="email" placeholder="E-mail" required>
                        <div class="senha">
                            <input type="password" name="senha" id="senha" placeholder="Senha" required>
                            <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i>
                        </div>
                        <input type="text" name="telefone" placeholder="Telefone" required>
                        <input type="date" name="nascimento" placeholder="Data de Nascimento" required>
                        <div class="sexo">
                            <select name="sexo">
                                <option value=null>Sexo:</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="O">Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="botao">
                        <input class="btn btn-primary entrar" type="submit" value="Adicionar">
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer>
    <?php include 'footer.php'; ?>
    </footer>
    <script src="./Script/main.js"></script>
</body>

</html>
