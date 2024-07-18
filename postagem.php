<?php
session_start();
require_once 'config/config.php'; // Inclua o arquivo de configuração do banco de dados
require_once 'classes/Usuario.php';
require_once 'classes/Post.php';

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
$foto = $dados_usuario['foto'];

// Verificar se o método de requisição é POST (formulário foi submetido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data = date('Y/m/d');

    // Verificar se foi enviado um novo arquivo de imagem
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

        $nome_arquivo = uniqid() .$idUsuario;
        $caminho_temporario = $_FILES['imagem']['tmp_name'];
        $caminho_destino = 'img/' . $nome_arquivo;
        
        // Mover o arquivo carregado para o destino
        if (move_uploaded_file($caminho_temporario, $caminho_destino)) {
            // Atualizar o caminho da imagem no banco de dados
            $imagem = 'img/' . $nome_arquivo; // Salva o caminho relativo da imagem

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
    <link rel="stylesheet" href="css/postagem.css">
    <title>PetHub - Criar Postagem</title>
</head>

<body>
<nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    <img src="img/LogoWhite.png" alt="">
                </h2>
            </a>

            <div class="create">
                <!-- <a href="cadastro.php"><label class="btn btn-primary">Cadastrar</label></a>
                <a href="contato.php"><label class="btn btn-primary">Voltar</label></a> -->
                <div class="profile-photo">

                    <a class="nav-theme" href="index.php"><?php echo "<img src= '$foto'>"; ?>
                        <div class="nav-popup">
                            <div class="perfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-regular fa-user"></i>Perfil</span></a>
                            </div>
                            <div class="editarPerfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
                            </div>
                            <div class="logout">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-solid fa-right-from-bracket"></i>Sair</span></a>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </nav>
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
    <footer>
    <?php include 'footer.php'; // Inclua o rodapé ?>
    </footer>
    <script src="Script/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pontosPopups = document.querySelectorAll('.fa-ellipsis');
            const profileImgs = document.querySelectorAll('.profile-img');

            pontosPopups.forEach(pontosPopup => {
                pontosPopup.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const popupId = 'pontinhos-popup-' + this.id.split('-').pop();
                    const popup = document.getElementById(popupId);
                    if (popup) {
                        popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
                    }
                    closeOtherPopups(popupId);
                });
            });

            profileImgs.forEach(profileImg => {
                profileImg.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const popupId = 'nav-popup-' + this.id.split('-').pop();
                    const popup = document.getElementById(popupId);
                    if (popup) {
                        popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
                    }
                    closeOtherPopups(popupId);
                });
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('.pontinhos-popup, .nav-popup').forEach(popup => {
                    popup.style.display = 'none';
                });
            });

            function closeOtherPopups(openPopupId) {
                document.querySelectorAll('.pontinhos-popup, .nav-popup').forEach(popup => {
                    if (popup.id !== openPopupId) {
                        popup.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>

</html>