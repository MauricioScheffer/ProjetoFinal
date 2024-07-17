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

$usuario = new Usuario($db);
//dados do dono do perfil
// Verificar se foi passado o parâmetro 'id' via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dados_usuario = $usuario->lerPorId($id);
} else {
    // Redirecionar se não houver ID válido
    header('Location: index.php');
    exit();
}
$idUsuario = $dados_usuario['id'];
$foto = $dados_usuario['foto'];
$nome = $dados_usuario['nome'];
$apelido = $dados_usuario['apelido'];

//Dados do usuário logado
$usuario_logado = $usuario->lerPorId($_SESSION['usuario_id']);
$usuario_adm = $usuario_logado['adm'];
$fotoLogado = $usuario_logado['foto'];

// referenciando para saber se o usuário segue ou não o perfil
$seguidor = new Seguidor($db);

// Consulta para saber se o usuário já segue o perfil
$seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);

// Consulta para sabwer quantos seguidores o perfil tem
$seguidores = $seguidor->seguidores($idUsuario);

//seguir ou deixar de seguir
if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'seguir' && !$seguindo) {
        $seguidor->seguir($idUsuario, $_SESSION['usuario_id']);
        $seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);
        $seguidores = $seguidor->seguidores($idUsuario);
    } elseif ($_POST['acao'] == 'desseguir') {
        $seguidor->desseguir($idUsuario, $_SESSION['usuario_id']);
        $seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);
        $seguidores = $seguidor->seguidores($idUsuario);
    }
}

$postagem = new Post($db);
$postagens = $postagem->lerPorUsuario($idUsuario);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Perfil</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    <img src="img/LogoBlack.png" alt="">
                </h2>
            </a>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Pesquisar">
            </div>
            <div class="create">
                <?php if ($idUsuario == $_SESSION['usuario_id']) : ?>
                    <a href="postagem.php"><label class="btn btn-primary" readonly>Publicar</label></a>
                <?php endif; ?>

                <div class="profile-photo">
                    <a class="nav-theme">
                        <?php echo "<img class='profile-img' id='profile-img-{$idUsuario}' src='$fotoLogado'>"; ?>
                        <div class="nav-popup" id="nav-popup-<?php echo $idUsuario; ?>">
                            <div class="perfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>">
                                    <span><i class="fa-regular fa-user"></i>Perfil</span>
                                </a>
                            </div>
                            <div class="editarPerfil">
                                <a href="editarUsuario.php?id=<?php echo $idUsuario; ?>">
                                    <span><i class="fa-solid fa-user-pen"></i>Editar Perfil</span>
                                </a>
                            </div>
                            <div class="logout">
                                <a href="logout.php">
                                    <span><i class="fa-solid fa-right-from-bracket"></i>Sair</span>
                                </a>
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
            <!-- LEFT -->
            <div class="left">
                <a class="profile">
                    <div class="profile-photo">
                        <a class="nav-theme">
                            <?php echo "<img class='profile-img' id='profile-img-logged' src= '$fotoLogado'>"; ?>
                            <div class="nav-popup" id="nav-popup-logged">
                                <div class="editarPerfil">
                                    <a href="editarUsuario.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="handle">
                        <h4><?php echo "$nome"; ?></h4>
                        <p class="text-muted">
                            <?php echo "@$apelido"; ?>
                        </p>
                        <h3><?php echo "Seguidores $seguidores"; ?></h3>
                        <?php if ($idUsuario != $_SESSION['usuario_id']) : ?>
                            <form method="post">
                                <?php if ($seguindo) : ?>
                                    <button type="submit" name="acao" value="desseguir">Seguindo</button>
                                <?php else : ?>
                                    <button type="submit" name="acao" value="seguir">Seguir</button>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>

                        <!-- <div class="input-single">
                            <textarea class="input" name="" type="text"></textarea>
                            <label for="nome">Meus Pets🐶</label>
                        </div>
                        <input type="submit" value="Salvar" class="btn btn-primary btn-post"> -->

                    </div>
                </a>
            </div>

            <!-- meio -->
            <div class="middle">
                <?php while ($post = $postagens->fetch(PDO::FETCH_ASSOC)) : ?>
                    <?php
                    // Obtendo dados do usuário da postagem
                    $usuarioPostagem = $usuario->lerPorId($post['idUsuario']);

                    // Referenciando para saber se o usuário segue ou não o usuário da postagem
                    $seguidor = new Seguidor($db);

                    // Consulta para saber se o usuário já segue o perfil
                    $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);

                    // Seguir ou deixar de seguir
                    if (isset($_POST['acao'])) {
                        if ($_POST['acao'] == 'seguir' && !$seguindo) {
                            $seguidor->seguir($usuarioPostagem['id'], $idUsuario);
                            $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
                        } elseif ($_POST['acao'] == 'desseguir') {
                            $seguidor->desseguir($usuarioPostagem['id'], $idUsuario);
                            $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
                        }
                    }
                    ?>
                    <!-- Publicações -->
                    <div class="feeds">
                        <!-- Publicação -->
                        <div class="feed">
                            <div class="head">
                                <div class="user">
                                    <div class="profile-photo">
                                        <a href="perfil.php?id=<?php echo $usuarioPostagem['id']; ?>">
                                            <?php echo "<img src='{$usuarioPostagem['foto']}' />"; ?>
                                        </a>
                                    </div>
                                    <div class="ingo">
                                        <h3><?php echo $usuarioPostagem['nome']; ?></h3>
                                        <?php if ($usuarioPostagem['id'] != $idUsuario) : ?>
                                            <form method="post">
                                                <?php if ($seguindo) : ?>
                                                    <button type="submit" name="acao" value="desseguir">Seguindo</button>
                                                <?php else : ?>
                                                    <button type="submit" name="acao" value="seguir">Seguir</button>
                                                <?php endif; ?>
                                            </form>
                                        <?php endif; ?>
                                        <small><?php echo $post['titulo']; ?></small>
                                    </div>
                                </div>

                                <a class="edit-item">
                                    <span><i class="fa-solid fa-ellipsis" id="pontos-popup-<?php echo $post['id']; ?>"></i></span>
                                    <div class="pontinhos-popup" id="pontinhos-popup-<?php echo $post['id']; ?>">
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

                            <a href="comentario.php?postagem=<?php echo $post['id']; ?>">
                                <div class="comments text-muted">Ver todos os comentários</div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        </div>
        </div>
    </main>
    <div class="footer">
        <?php include 'footer.php'; // Inclua o rodapé 
        ?>
    </div>
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