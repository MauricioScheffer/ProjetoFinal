<?php
session_start();
require_once '../config/config.php'; // Inclua o arquivo de configuração do banco de dados
require_once '../classes/Usuario.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir o cabeçalho da página (HTML)


// Instanciar o objeto Usuario com a conexão ao banco de dados
$usuario = new Usuario($db);

// Verificar se foi passado o parâmetro 'id' via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
} else {
    // Redirecionar se não houver ID válido
    header('Location: perfil.php');
    exit();
}

// Ler dados do usuário logado para verificar permissões
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$usuario_adm = $dados_usuario['adm'];

// Verificar se o método de requisição é POST (formulário foi submetido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $sexo = $_POST['sexo'];
    $adm = isset($_POST['adm']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    // Verificar se foi enviado um novo arquivo de imagem
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        $nome_arquivo = $_FILES['foto']['name'];
        $caminho_temporario = $_FILES['foto']['tmp_name'];
        $caminho_destino = '../img/' . $nome_arquivo;
        
        // Mover o arquivo carregado para o destino
        if (move_uploaded_file($caminho_temporario, $caminho_destino)) {
            // Atualizar o caminho da imagem no banco de dados
            $foto = 'img/' . $nome_arquivo; // Salva o caminho relativo da imagem

            // Chamar o método para atualizar os dados do usuário, incluindo a foto
            $usuario->atualizar($nome, $email, $telefone, $sexo, $foto, $nascimento, $adm, $ativo, $id);
            header('Location: perfil.php');
            exit();
        } else {
            echo "Erro ao mover o arquivo para o diretório de destino.";
        }
    } else {
        // Se não houver novo arquivo de imagem, atualize os outros campos sem alterar a foto
        $foto_atual = $usuario->lerPorId($id)['foto']; // Obtém a foto atual do usuário
        $usuario->atualizar($nome, $email, $telefone, $sexo, $foto_atual, $nascimento, $adm, $ativo, $id);
        header('Location: perfil.php');
        exit();
    }
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
   

    <!-- main -->
    <main>
        <div class="container">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="meio">
                    <h2>Editar Perfil</h2>
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
                        <!-- Campo para selecionar a foto -->
                        <input type="file" name="foto">
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
                    <input class="btn btn-primary entrar" type="submit" value="Salvar Alterações">
                </div>
            </form>
        </div>
    </main>
    <?php include 'footer.php'; // Inclua o rodapé ?>
    <script src="../Script/main.js"></script>
</body>

</html>
