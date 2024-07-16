<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'config/config.php';
include_once 'classes/Usuario.php';
include_once 'Classes/Seguidor.php';
include_once 'classes/Post.php';
include_once 'classes/Comentario.php';

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

// referenciando para saber se o usuário segue ou não o usuário da postagem
$seguidor = new Seguidor($db);

// Consulta para saber se o usuário já segue o perfil
$seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);

//seguir ou deixar de seguir
if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'seguir' && !$seguindo) {
        $seguidor->seguir($usuarioPostagem['id'], $idUsuario);
        $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
    } elseif ($_POST['acao'] == 'desseguir') {
        $seguidor->desseguir($usuarioPostagem['id'], $idUsuario);
        $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
    }
}

//Comentários
$comentario = new Comentario($db);
$comentarios = $comentario->ler($idPostagem);

// Verificar se o método de requisição é POST (formulário foi submetido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['descricao']) {
        // Obter os dados do formulário
        $descricao = $_POST['descricao'];
        $data = date('Y/m/d');

        // Criar comentario
        $comentario->criar($idPostagem, $idUsuario, $descricao, $data);
        header("Location: comentario.php?postagem=$idpostagem");
    } else if ($_POST['acao'] == '') {
        echo '<script>
     window.onload= function() {
      alert("O comentário não pode ser vazio!");
     }
     </script>';
    } else if ($_POST['acao'] == '' && !$_POST['descricao']){
        echo '<script>
        window.onload= function() {
         alert("Erro grave, ferrou de vez!");
        }
        </script>';
    }

}

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
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-regular fa-user"></i>Perfil</span></a>
                            </div>
                            <div class="editarPerfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
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
                                <?php if ($usuarioPostagem['id'] != $idUsuario): ?>
                                    <form method="post">
                                        <?php if ($seguindo): ?>
                                            <button type="submit" name="acao" value="desseguir">Seguindo</button>
                                        <?php else: ?>
                                            <button type="submit" name="acao" value="seguir">Seguir</button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                                <small><?php echo $post['titulo']; ?></small>
                            </div>
                        </div>
                        <a class="edit-item">
                            <span><i id="pontos-popup" class="fa-solid fa-ellipsis"></i></span>
                            <div class="pontinhos-popup" id="pontinhos-popup">
                                <div class="editar">
                                    <span><i class="fa-regular fa-pen-to-square"></i>Editar</span>
                                </div>
                                <div class="deletar">
                                    <span><i class="fa-regular fa-trash-can"></i>Deletar</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="photo">
                        <?php echo "<img src='{$post['imagem']}' />"; ?>
                    </div>

                    <div class="action-buttons">
                        <div class="interaction-buttons">
                            <span><i class="fa-regular fa-heart"></i></span>
                            <span><i class="fa-regular fa-comment"></i></span>
                            <span><i class="fa-solid fa-square-share-nodes"></i></span>
                        </div>

                        <div class="bookmark">
                            <span><i class="fa-regular fa-bookmark"></i></span>
                        </div>
                    </div>

                    <div class="liked-by">
                        <span><img src="img/perfil.jpg"></span>
                        <span><img src="img/kauaV.jpg"></span>
                        <span><img src="img/arthur.jpg"></span>
                        <p>Curtido por <b>Dalmo Xiru</b> e <b>1,564 outros</b></p>
                    </div>

                    <div class="caption">
                        <p><b><?php echo $usuarioPostagem['nome']; ?></b> <?php echo $post['descricao']; ?>
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <div class="comentarios">

            <?php
            if ($comentarios) {
                while ($comentado = $comentarios->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php
                    //Obtendo dados do usuário do comentário
                    $usuarioComentario = $usuario->lerPorId($comentado['idUsuario']);

                    // referenciando para saber se o usuário segue ou não o usuário do comentário
                    $seguidorComentario = new Seguidor($db);

                    // Consulta para saber se o usuário já segue o comentador
                    $seguindo = $seguidor->ler($usuarioComentario['id'], $idUsuario);

                    //seguir ou deixar de seguir
                    if (isset($_POST['acao'])) {
                        if ($_POST['acao'] == 'seguir' && !$seguindo) {
                            $seguidor->seguir($usuarioComentario['id'], $idUsuario);
                            $seguindo = $seguidor->ler($usuarioComentario['id'], $idUsuario);
                        } elseif ($_POST['acao'] == 'desseguir') {
                            $seguidor->desseguir($usuarioComentario['id'], $idUsuario);
                            $seguindo = $seguidor->ler($usuarioComentario['id'], $idUsuario);
                        }
                    }
                    ?>
                    <div class="middle">
                        <!-- publicações -->
                        <div class="feeds">
                            <!-- publicação -->
                            <div class="feed">
                                <div class="head">
                                    <div class="user">
                                        <div class="profile-photo">
                                            <a
                                                href="perfil.php?id=<?php echo $usuarioComentario['id']; ?>"><?php echo "<img src='{$usuarioComentario['foto']}' />"; ?></a>
                                        </div>
                                        <div class="ingo">
                                            <h3><?php echo $usuarioComentario['nome']; ?></h3>
                                            <?php if ($usuarioComentario['id'] != $idUsuario): ?>
                                                <form method="post">
                                                    <?php if ($seguindo): ?>
                                                        <button type="submit" name="acao" value="desseguir">Seguindo</button>
                                                    <?php else: ?>
                                                        <button type="submit" name="acao" value="seguir">Seguir</button>
                                                    <?php endif; ?>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a class="edit-item">
                                    <span><i id="comentario-popup" class="fa-solid fa-ellipsis"></i></span>
                                        <div class="pontinhos-popup" id="comentario-popup-div">
                                            <div class="editar">
                                                <span><i class="fa-regular fa-pen-to-square"></i>Editar</span>
                                            </div>
                                            <div class="deletar">
                                                <span><i class="fa-regular fa-trash-can"></i>Deletar</span>
                                            </div>  
                                        </div>
                                    </a>
                                </div>
                                <div class="caption">
                                    <p>
                                        <?php echo $comentado['descricao']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php endwhile;
            }
            ?>
        </div>

        <div class="comentar">
            <form method="POST" enctype="multipart/form-data">
                <div class="meio">
                    <h2>Comentar</h2>
                    <div class="caixas">
                        <textarea name="descricao" placeholder="Deixe um comentário"></textarea>
                    </div>
                    <input class="btn btn-primary entrar" type="submit" value="comentar">
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
    <?php include 'footer.php'; // Inclua o rodapé ?>
    </div>

    <script src="Script/main.js"></script>
</body>
</html>