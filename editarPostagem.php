<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'config/config.php';
include_once 'classes/Usuario.php';
include_once 'classes/Post.php';

//Obtendo dados do usuário logado
$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$idUsuario = $dados_usuario['id'];
$foto = $dados_usuario['foto'];
$nome = $dados_usuario['nome'];
$apelido = $dados_usuario['apelido'];
$admin = $dados_usuario['adm'];

//Postagem 
$postagem = new Post($db);
// Verificar se foi passado o parâmetro 'idPostagem' via GET
if (isset($_GET['postagem'])) {
    $idPostagem = $_GET['postagem'];
    $post = $postagem->lerPostagem($idPostagem);
} else {
    // Redirecionar se não houver ID válido
    header('Location: index.php');
    exit();
}

//Obtendo dados do usuário da postagem
$usuarioPostagem = $usuario->lerPorId($post['idUsuario']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/comentario.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>PetHub Social</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    <img src="img/LogoBlack.png">
                </h2>
            </a>
            <div class="create">
                <div class="profile-photo">
                    <a class="nav-theme"><?php echo "<img id='profile-img' src= '$foto'>"; ?>
                        <div class="nav-popup" id="nav-popup">
                            <div class="perfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-regular fa-user"></i>Perfil</span></a>
                            </div>
                            <div class="editarPerfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
                            </div>
                            <div class="logout">
                                <a href="logout.php"><span><i class="fa-solid fa-right-from-bracket"></i>Sair</span></a>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </nav>
    <div class="container-meio">
        <form method="POST" enctype="multipart/form-data">
            <!-- meio -->
            <div class="middle">
                <!-- publicações -->
                <div class="feeds">
                    <!-- publicação -->
                    <div class="feed">
                        <div class="head">
                            <div class="user">
                                <div class="profile-photo">
                                    <a href="perfil.php?id=<?php echo $usuarioPostagem['id']; ?>"><?php echo "<img src='{$usuarioPostagem['foto']}' />"; ?></a>
                                </div>
                                <div class="ingo">
                                    <h3><?php echo $usuarioPostagem['nome']; ?></h3>

                                    <input name="titulo" value="<?php echo $post['titulo']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <p>Click no botão abaixo para escolher uma nova imagem para a postagem</p><input type="file" name="imagem">
                        <div class="photo">
                            <?php echo "<img src='{$post['imagem']}' />"; ?>
                        </div>

                        <div class="caption">
                            <p><b><?php echo $usuarioPostagem['nome']; ?></b> <input name="descricao" value="<?php echo $post['descricao']; ?>" required>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="footer">
        <?php include 'footer.php'; // Inclua o rodapé 
        ?>
    </div>

    <script src="Script/main.js"></script>
</body>

</html>