<?php
session_start();
require_once '../config/config.php'; // Inclua o arquivo de configuração do banco de dados
require_once '../classes/Usuario.php';
require_once '../classes/Post.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir o cabeçalho da página (HTML)


// Instanciar o objeto Usuario com a conexão ao banco de dados
$usuario = new Usuario($db);
$postagem = new Post($db);
// Ler dados do usuário logado para verificar permissões
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$idUsuario = $dados_usuario['id'];

// Verificar se o método de requisição é POST (formulário foi submetido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data = date('Y/m/d');

    // Verificar se foi enviado um novo arquivo de imagem
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

        $nome_arquivo = $_FILES['imagem']['name'];
        $caminho_temporario = $_FILES['imagem']['tmp_name'];
        $caminho_destino = '../img/' . $nome_arquivo;
        
        // Mover o arquivo carregado para o destino
        if (move_uploaded_file($caminho_temporario, $caminho_destino)) {
            // Atualizar o caminho da imagem no banco de dados
            $imagem = '../img/' . $nome_arquivo; // Salva o caminho relativo da imagem

            // Chamar o método para criar os dados da postagem, incluindo a foto
            $postagem->criar($idUsuario, $titulo, $descricao, $imagem, $data);
            header('Location: perfil.php');
            exit();
        } else {
            echo "Erro ao mover o arquivo para o diretório de destino.";
        }
        // Se não houver arquivo de imagem, criar os outros campos sem adicionar a foto
        $postagem->criar($idUsuario, $titulo, $descricao, $imagem, $data);
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
    <title>Criar Postagem</title>
</head>

<body>
   

    <!-- main -->
    <main>
        <div class="container">
            <form method="POST" enctype="multipart/form-data">
                <div class="meio">
                    <h2>Criar Postagem</h2>
                    <div class="caixas">
                        <input type="text" name="titulo" placeholder="Título" required>
                        <!-- Campo para selecionar a foto -->
                        <input type="file" name="imagem">
                       <textarea name="descricao" id="descricao" placeholder="Descrição"></textarea>
                        
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