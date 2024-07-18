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
$postagens = $postagem->lerPorSeguidor($idUsuario);


// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Obter dados da notícia com filtro
if ($search) {
    $postagens = $postagem->ler($search);
}

// Obter os usuários mais seguidos quando não pesquisado nenhum amigo 

$usuarios = $usuario->maisSeguidos();

// Obter dados dos usuários
$searchPeople = isset($_GET['search-people']) ? $_GET['search-people'] : '';
if ($searchPeople) {
    // Buscar usuários com base na pesquisa de pessoas
    $usuarios = $usuario->lerUsuarios($searchPeople);
}


$curtida = new Curtida($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>PetHub</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    <img id="imagem" src="img/LogoBlack.png" alt="">
                </h2>
            </a>

            <div class="search-bar">
                <form method="GET">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" placeholder="Pesquisar" name="search" value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <div class="create">



                <div class="profile-photo">

                    <a class="nav-theme">
                        <?php echo "<img class='profile-img' id='profile-img-{$idUsuario}' src='$foto'>"; ?>
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
                        <?php echo "<img src= '$foto'>"; ?>
                    </div>
                    <div class="handle">
                        <h4><?php echo "$nome"; ?></h4>
                        <p class="text-muted">
                            <?php echo "@$apelido"; ?>
                        </p>
                    </div>
                </a>
                <!-- sidebar -->
                <div class="sidebar">
                    <a class="menu-item active" id="inicio">
                        <span><i class="fa-solid fa-house"></i></span>
                        <h3>Inicio</h3>
                    </a>
                    <a class="menu-item" id="explorar">
                        <span><i class="fa-brands fa-wpexplorer"></i></i></span>
                        <h3>Explorar</h3>
                    </a>

                    <?php if ($admin == 1) {
                    ?><a href="indexAdm.php" class="menu-item">
                            <span><i class="fa-solid fa-chart-simple"></i></span>
                            <h3>Analises</h3>
                        </a>
                    <?php } ?>
                    <a class="menu-item" id="theme">
                        <span><i class="fa-solid fa-circle-half-stroke"></i></span>
                        <h3>Tema</h3>
                    </a>

                    <!-- <a class="menu-item">
                        <span><i class="fa-solid fa-gear"></i></span>
                        <h3>Configurações</h3>
                    </a> -->

                </div>
                <!-- cabou a sidebar -->
                <a href="postagem.php"><input for="create-post" class="btn btn-primary" value="Criar publicação" readonly></a>
            </div>
            <!-- fim da esquerda -->

            <!-- meio -->
            <div class="middle">
                <?php while ($post = $postagens->fetch(PDO::FETCH_ASSOC)) : ?>
                    <?php
                    // Obtendo dados do usuário da postagem
                    $usuarioPostagem = $usuario->lerPorId($post['idUsuario']);
                    $jaCurtiu = $curtida->jaCurtiu($post['id'], $_SESSION['usuario_id']);
                    $totalCurtidas = $curtida->contarCurtidas($post['id']);
                    $curtidas = $curtida->obterCurtidas($post['id']);

                    //  // referenciando para saber se o usuário segue ou não o usuário da postagem
                    //  $seguidor = new Seguidor($db);

                    //  // Consulta para saber se o usuário já segue o perfil
                    //  $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
 
                    //  //seguir ou deixar de seguir
                    //  if (isset($_POST['acao'])) {
                    //      if ($_POST['acao'] == 'seguir' && !$seguindo) {
                    //          $seguidor->seguir($usuarioPostagem['id'], $idUsuario);
                    //          $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
                    //      } elseif ($_POST['acao'] == 'desseguir') {
                    //          $seguidor->desseguir($usuarioPostagem['id'], $idUsuario);
                    //          $seguindo = $seguidor->ler($usuarioPostagem['id'], $idUsuario);
                    //      }
                    //  }
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

                                <a class="edit-item">
                                    <?php if ($admin || $_SESSION['usuario_id'] == $usuarioPostagem['id']) : ?>
                                        <a class="links" href="editarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-pen-to-square"></i>Editar</span></a>

                                        <!-- </div> -->
                                        <!-- <div class="deletar"> -->

                                        <a class="links" href="deletarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-trash-can"></i>Deletar</span>
                                        <?php endif; ?>
                                        </a>
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
                            <a href="comentario.php?postagem=<?php echo $post['id']; ?>">
                                <div class="comments text-muted">Ver todos os comentários</div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="right">
                <form method="GET" class="search-bar-right">
                    <button type="submit" class="search-bar-icone"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" placeholder="Busque amigos aqui..." name="search-people" value="<?php echo htmlspecialchars($searchPeople); ?>">
                </form>
                <div class="messages">
                    <div class="heading">

                        <?php
                        if ($searchPeople) {
                            echo "<h4>Procurando amigo pet huber<h4>";
                        } else {
                            echo "<h4>pet hubers mais seguidos<h4>";
                        }
                        ?>
                        <!-- classe mudar -->
                    </div>
                    <?php
                    while ($usu = $usuarios->fetch(PDO::FETCH_ASSOC)) : ?>
                        <!-- mensagem -->
                        <div class="message">
                            <div class="profile-photo">
                                <?php echo "<img src='{$usu['foto']}' />"; ?>
                            </div>
                            <div class="handle">
                                <h4><?php echo $usu['nome']; ?></h4>
                                <p class="text-muted">
                                    <?php echo "@{$usu['apelido']}"; ?>
                                </p>
                                <a href="perfil.php?id=<?php echo $usu['id']; ?>">
                                    <p class="text-bold">Ver Perfil</p>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;

                    ?>
                </div>
                <!-- fim das mensagens -->


            </div>
        </div>

        <!-- fim direito -->

    </main>

    <div class="customize-theme">
        <div class="card">
            <h2 class="text-muted">Customize do Seu Jeito</h2>
            <p>Organize sua Fonte, Cor e Fundo</p>

            <!-- fontes -->
            <div class="font-size">
                <h4>Fontes</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2"></span>
                        <span class="font-size-3 active"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>

            <!-- cores -->
            <div class="color">
                <h4>Cores</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            <!-- fundo -->
            <div class="background">
                <h4>Tema do Fundo</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Claro</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Sombreado</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5>Dark</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>



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

        document.addEventListener('DOMContentLoaded', function() {
            const inicio = document.getElementById('inicio');
            const explorar = document.getElementById('explorar');

            inicio.addEventListener('click', function(event) {
                event.preventDefault(); // Evita o comportamento padrão do link

                // Requisição AJAX para ler postagens por seguidor
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'atualizarPostagens.php?tipo=seguidor&idUsuario=<?php echo $idUsuario; ?>', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Sucesso na requisição
                        var response = xhr.responseText;
                        document.querySelector('.middle').innerHTML = response; // Atualiza a área das postagens
                    } else {
                        // Tratar erro
                        console.error('Erro ao carregar postagens por seguidor. Status: ' + xhr.status);
                    }
                };
                xhr.send();
            });

            explorar.addEventListener('click', function(event) {
                event.preventDefault(); // Evita o comportamento padrão do link

                // Requisição AJAX para ler todas as postagens
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'atualizarPostagens.php?tipo=todas', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Sucesso na requisição
                        var response = xhr.responseText;
                        document.querySelector('.middle').innerHTML = response; // Atualiza a área das postagens
                    } else {
                        // Tratar erro
                        console.error('Erro ao carregar todas as postagens. Status: ' + xhr.status);
                    }
                };
                xhr.send();
            });
        });
    </script>
</body>

</html>