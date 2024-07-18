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
include_once 'Classes/Curtida.php';

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

$curtida = new Curtida($db);

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
                    </div>
                </a>
            </div>

            <!-- meio -->
            <div class="middle">
                <?php while ($post = $postagens->fetch(PDO::FETCH_ASSOC)) : ?>
                    <?php
                    // Obtendo dados do usuário da postagem
                    $usuarioPostagem = $usuario->lerPorId($post['idUsuario']);
                    $jaCurtiu = $curtida->jaCurtiu($post['id'], $_SESSION['usuario_id']);
                    $totalCurtidas = $curtida->contarCurtidas($post['id']);
                    $curtidas = $curtida->obterCurtidas($post['id']);
                    ?>
                    <!-- Publicações -->
                    <div class="feeds" id="post-<?php echo $post['id']; ?>">
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
                                        <small><?php echo $post['titulo']; ?></small>
                                    </div>
                                </div>

                                <div class="post-items">
                                <a class="edit-item">
                                    <!-- <span><i class="fa-solid fa-ellipsis" class="pontos-popup"></i></span> -->
                                    <!-- <div class="pontinhos-popup" id="pontinhos-popup"> -->
                                    <!-- <div class="editar"> -->
                                    <?php if ($usuario_adm || $_SESSION['usuario_id'] == $usuarioPostagem['id']) : ?>
                                        <a class="links" href="editarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-pen-to-square"></i>Editar</span></a>

                                        <!-- </div> -->
                                        <!-- <div class="deletar"> -->

                                        <a class="links" href="deletarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-trash-can"></i>Deletar</span>
                                        <?php endif; ?>
                                        <!-- </div> -->
                                        <!-- </div> -->
                                    </a>
                                    </div>
                            </div>

                            <div class="photo">
                                <?php echo "<img src='{$post['imagem']}' />"; ?>
                            </div>

                            <div class="action-buttons">
                                <div class="interaction-buttons">
                                    <button onclick="likePost(<?php echo $post['id']; ?>, '<?php echo $jaCurtiu ? 'descurtir' : 'curtir'; ?>')">
                                        <i class="<?php echo $jaCurtiu ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                                    </button>
                                </div>
                                <div class="bookmark">
                                    <span><i class="fa-regular fa-bookmark"></i></span>
                                </div>
                            </div>

                            <div class="liked-by">
                                <?php foreach ($curtidas as $curtidor) : ?>
                                    <span><img src="<?php echo $curtidor['foto']; ?>" alt=""></span>
                                <?php endforeach; ?>
                                <p><b><?php echo $totalCurtidas; ?> pessoa(s) curtiram isso</b></p>
                            </div>

                            <div class="caption">
                                <p><b><?php echo $usuarioPostagem['nome']; ?></b> <?php echo $post['descricao']; ?></p>
                            </div>
                            <div class="comments text-muted">
                                <a href="comentario.php?postagem=<?php echo $post['id']; ?>">
                                    <div class="comments text-muted">Ver todos os comentários</div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- RIGHT -->
            <!-- <div class="right">
                <div class="messages">
                    <div class="heading">
                        <h4>Mensagens</h4><i class="fa-regular fa-edit"></i>
                    </div>
                    search bar
                    <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" placeholder="Pesquisar mensagens" id="message-search">
                    </div>

                    Categorias de mensagem
                    <div class="category">
                        <h6 class="active">Primary</h6>
                        <h6>Geral</h6>
                        <h6>Solicitações</h6>
                    </div>

                    Mensagens
                    <div class="message">
                        <div class="profile-photo">
                            <img src="img/Perfil/FotoPerfil.jpg" alt="">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Stefani Jhonson</h5>
                            <p class="text-muted">Mensagem recebida</p>
                        </div>
                    </div>
                    <div class="message">
                        <div class="profile-photo">
                            <img src="img/Perfil/FotoPerfil.jpg" alt="">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Stefani Jhonson</h5>
                            <p class="text-muted">Mensagem recebida</p>
                        </div>
                    </div>
                    <div class="message">
                        <div class="profile-photo">
                            <img src="img/Perfil/FotoPerfil.jpg" alt="">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Stefani Jhonson</h5>
                            <p class="text-muted">Mensagem recebida</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </main>
        
    <script>
        // Função para curtir/descurtir post
        function likePost(postId, action) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "like_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var postElement = document.getElementById('post-' + postId);
                        var likeButton = postElement.getElementsByTagName('button')[0];
                        var likeIcon = likeButton.getElementsByTagName('i')[0];

                        // Atualiza o ícone e a ação
                        if (action == 'curtir') {
                            likeButton.setAttribute('onclick', `likePost(${postId}, 'descurtir')`);
                            likeIcon.className = 'fa-solid fa-heart';
                        } else {
                            likeButton.setAttribute('onclick', `likePost(${postId}, 'curtir')`);
                            likeIcon.className = 'fa-regular fa-heart';
                        }

                        // Atualiza o contador de likes
                        var likesCount = postElement.getElementsByClassName('liked-by')[0].getElementsByTagName('p')[0];
                        likesCount.innerHTML = '<b>' + response.likes + ' pessoa(s) curtiram isso</b>';
                    }
                }
            };
            xhr.send("id=" + postId + "&acaoCurtida=" + action);
        }

        // Função para exibir/ocultar popup do menu do usuário
        document.addEventListener('DOMContentLoaded', function() {
            var profileImg = document.getElementById('profile-img-logged');
            var navPopup = document.getElementById('nav-popup-logged');

            profileImg.addEventListener('click', function() {
                navPopup.style.display = navPopup.style.display === 'none' || navPopup.style.display === '' ? 'block' : 'none';
            });

            // Esconder o popup ao clicar fora
            document.addEventListener('click', function(event) {
                if (!profileImg.contains(event.target) && !navPopup.contains(event.target)) {
                    navPopup.style.display = 'none';
                }
            });
        });

        // Função para exibir/ocultar popup dos pontos nas publicações
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-item').forEach(function(editItem) {
                var pontosPopup = editItem.querySelector('.pontinhos-popup');
                var pontosIcon = editItem.querySelector('i');

                pontosIcon.addEventListener('click', function() {
                    pontosPopup.style.display = pontosPopup.style.display === 'none' || pontosPopup.style.display === '' ? 'block' : 'none';
                });

                // Esconder o popup ao clicar fora
                document.addEventListener('click', function(event) {
                    if (!editItem.contains(event.target) && !pontosPopup.contains(event.target)) {
                        pontosPopup.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <footer class="footer">
        <?php include 'footer.php'?>
    </footer>
</body>

</html>