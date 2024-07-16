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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Responsivo Web Site</title>
</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    Rede Social
                </h2>
            </a>

            <div class="search-bar">
                <form method="GET">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" placeholder="Pesquisar" name="search"
                        value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <div class="create">
                
                <!-- <a href="cadastro.php"><label class="btn btn-primary">Cadastrar</label></a>
                <a href="contato.php"> <label class="btn btn-primary">Contato</label></a> -->

                <div class="profile-photo">

                    <a class="nav-theme"><?php echo "<img id='profile-img' src= '$foto'>"; ?>
                        <div class="nav-popup" id="nav-popup">
                            <div class="perfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-regular fa-user"></i>Perfil</span></a>
                            </div>
                            <div class="editarPerfil">
                                <a href="editarUsuario.php?id=<?php echo $idUsuario; ?>"><span><i
                                            class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
                            </div>
                            <div class="logout">
                                <a href="logout.php"><span><i
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
                    <a class="menu-item active">
                        <span><i class="fa-solid fa-house"></i></span>
                        <h3>Inicio</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="fa-brands fa-wpexplorer"></i></i></span>
                        <h3>Explorar</h3>
                    </a>
                    <!-- <a class="menu-item" id="notifications">
                        <span><i class="fa-solid fa-envelope"><small class="notification-count">9</small></i></span>
                        <h3>Notificações</h3>

                        <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img src="img/vitor.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Vitor de Abreu</b> aceitou sua solicitação de amigo!
                                    <small class="text-muted">1 HORA ATRÁS</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="img/jeferson.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Jeferson Leon</b> comentou em sua publicação
                                    <small class="text-muted">7 HORAS ATRÁS</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="img/kauaV" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Kaua Valim</b> começou a te seguir
                                    <small class="text-muted">18 HORAS ATRÁS</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="img/murilo.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Murilo Torres</b> reagiu sua publicação
                                    <small class="text-muted">1 DIA ATRÁS</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="img/arthur.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Arthur Maciel</b> enviou uma solicitação para te seguir
                                    <small class="text-muted">2 DIAS ATRÁS</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="img/leo.jpg" alt="">
                                </div>
                                <div class="notification-body">
                                    <b>Leonardo Brum</b> comentou na sua publicação
                                    <small class="text-muted">3 DIAS ATRÁS</small>
                                </div>
                            </div>
                        </div>
                    </a> -->

                    <?php if ($admin == 1) {
                        ?><a class="menu-item">
                            <span><i class="fa-solid fa-chart-simple"></i></span>
                            <h3>Analises</h3>
                        </a>
                    <?php } ?>
                    <a class="menu-item" id="theme">
                        <span><i class="fa-solid fa-circle-half-stroke"></i></span>
                        <h3>Tema</h3>
                    </a>

                    <a class="menu-item">
                        <span><i class="fa-solid fa-gear"></i></span>
                        <h3>Configurações</h3>
                    </a>

                </div>
                <!-- cabou a sidebar -->
                <a href="postagem.php"><input for="create-post" class="btn btn-primary" value="Criar publicação"
                        readonly></a>
            </div>
            <!-- fim da esquerda -->

            <!-- meio -->
            <div class="middle">

                <?php while ($post = $postagens->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php
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
                    ?>
                    <!-- publicações -->
                    <div class="feeds">
                        <!-- publicação -->
                        <div class="feed">
                            <div class="head">
                                <div class="user">
                                    <div class="profile-photo">
                                        <a
                                            href="perfil.php?id=<?php echo $usuarioPostagem['id']; ?>"><?php echo "<img src='{$usuarioPostagem['foto']}' />"; ?></a>
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
                                    <span><i class="fa-solid fa-ellipsis" id="pontos-popup"></i></span>
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

                            <a href="comentario.php?postagem=<?php echo $post['id']; ?>"><div class="comments text-muted">Ver todos os comentários</div></a>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="right">
            <form method="GET" class="search-bar-right">
            <button type="submit" class="search-bar-icone"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" placeholder="Busque amigos aqui..." name="search-people"
                        value="<?php echo htmlspecialchars($searchPeople); ?>">
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
                    while ($usu = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
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
                                    <p class="text-bold"> Ver Perfil</p>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;

                    ?>
                </div>
                <!-- fim das mensagens -->

                <!-- solicitações de amigos -->
                <!-- <div class="friend-requests">
                    <h4>Solicitações</h4>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="img/vitor.jpg" alt="">
                            </div>
                            <div>
                                <h5>Vitinho</h5>
                                <p class="text-muted">
                                    4 amigos em comum
                                </p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">
                                Aceitar
                            </button>
                            <button class="btn">
                                Recusar
                            </button>
                        </div>
                    </div>
                 </div> -->
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

    <!-- <div class="foto-user">
        <div class="deletar">
            <span><i class="fa-regular fa-trash-can"></i>Deletar</span>
        </div>
    </div> -->

    <div class="footer">
    <?php include 'footer.php'; // Inclua o rodapé ?>
    </div>
    <script src="Script/main.js"></script>
</body>

</html>