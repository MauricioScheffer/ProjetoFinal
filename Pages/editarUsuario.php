<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once '../config/config.php';
include_once '../classes/Usuario.php';
$usuario = new Usuario($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}

$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$usuario_adm = $dados_usuario['adm'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $foto = "";
    $telefone = $_POST['telefone'];
    $nascimento = date($_POST['nascimento']);
    $sexo = $_POST['sexo'];
    $adm = isset($_POST['adm']) ? 1 : 0; // 1 = verdadeiro, 0 = falso
    $ativo = isset($_POST['ativo']) ? 1 : 0; // 1 = verdadeiro, 0 = falso

    $usuario->atualizar($nome, $email, $telefone, $senha, $foto, $nascimento, $adm, $ativo, $id);
    header('Location: perfil.php');
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
    <title>Editar Perfil</title>
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
                <a href="index.php"><label class="btn btn-primary" for="create-post">Voltar</label></a>
            </div>
        </div>
    </nav>

    <!-- main -->
    <main>

        <div class="container">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="meio">
                    <h2>Cadastrar</h2>
                    <div class="caixas">
                        <?php if ($usuario_adm == 1) : ?>
                            <div class="adm">
                                <label for="adm">Administrador</label>
                                <input type="checkbox" id="adm" name="adm" value="1" <?php echo ($row['adm'] == 1) ? 'checked' : ''; ?>>
                            </div>
                        <?php endif; ?>
                        <?php if ($usuario_adm == 1) : ?>
                            <div class="ativo">
                                <label for="ativo">Ativo</label>
                                <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo ($row['ativo'] == 1) ? 'checked' : ''; ?>>
                            </div>
                        <?php endif; ?>
                        <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
                        <input type="text" name="apelido" placeholder="Nome de usuário" value="<?php echo $row['apelido']; ?>" readonly>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

                        <input type="text" name="telefone" value="<?php echo $row['telefone']; ?>" required>
                        <input type="date" name="nascimento" value="<?php echo $row['nascimento']; ?>" required>

                        <div class="sexo">
                            <select name="sexo">
                                <option value="">Sexo:</option>
                                <option value="M" <?php echo ($row['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="F" <?php echo ($row['sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
                                <option value="O" <?php echo ($row['sexo'] == 'O') ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                    </div>
                    <input class="btn btn-primary entrar" type="submit" value="Adicionar">
                </div>
        </div>
        </div>
        </form>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="../Script/main.js"></script>
</body>

</html>