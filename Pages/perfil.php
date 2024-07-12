<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once '../config/config.php';
include_once '../classes/Usuario.php';
include_once '../Classes/Seguidor.php';
include_once '../classes/Post.php';

$usuario = new Usuario($db);
//o dados do usuario deve ler o id enviado pela tela index assim apresentando o perfil selecionado e não do usuario logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$idUsuario = $dados_usuario['id'];
$foto = $dados_usuario['foto'];
$nome = $dados_usuario['nome'];
$apelido = $dados_usuario['apelido'];

//o adm deve ser buscado pelo $_SESSION['usuario_id']
$usuario_adm = $dados_usuario['adm'];

// referenciando para saber se o usuário segue ou não o perfil
$seguidor = new Seguidor($db);

$seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);

//seguir ou deixar de seguir
if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'seguir') {
        $seguidor->seguir($idUsuario, $_SESSION['usuario_id']);
        $seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);
    } elseif ($_POST['acao'] == 'desseguir') {
        $seguidor->desseguir($idUsuario, $_SESSION['usuario_id']);
        $seguindo = $seguidor->ler($idUsuario, $_SESSION['usuario_id']);
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
    <link rel="stylesheet" href="../css/perfil.css">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Perfil</title>
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
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Pesquisar">
            </div>
            <div class="create">
                <?php if ($idUsuario == $_SESSION['usuario_id']) : ?>
                    <a href="postagem.php"><input class="btn btn-primary" value="Criar"></a>
                <?php endif; ?>
                <a href="contato.php"><input class="btn btn-primary" value="Contato"></a>
                <?php if ($usuario_adm == 1 || $idUsuario == $_SESSION['usuario_id']) : ?>
                    <a href="editarUsuario.php?id=<?php echo $idUsuario; ?>"><input class="btn btn-primary" value="Editar perfil"></a>
                <?php endif; ?>
                <div class="profile-photo">
                    <a href=""> <?php echo "<img src= '../$foto'>"; ?></a>
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
                        <a href=""><?php echo "<img src= '../$foto'>"; ?></a>
                    </div>
                    <div class="handle">
                        <h4><?php echo "$nome"; ?></h4>
                        <p class="text-muted">
                            <?php echo "@$apelido"; ?>
                        </p>
                        <!-- Removido o != $_SESSION['usuario_id'] do if para realizar testes  -->
                        <?php if ($idUsuario) : ?>
                            <form method="post">
                                <?php if ($seguindo) : ?>
                                    <button type="submit" name="acao" value="desseguir">Seguindo</button>
                                <?php else : ?>
                                    <button type="submit" name="acao" value="seguir">Seguir</button>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                        <div class="input-single">
                            <textarea class="input" name="" type="text"></textarea>
                            <label for="nome">Meus Pets🐶</label>
                        </div>
                        <input type="submit" value="Salvar" class="btn btn-primary btn-post">
                    </div>
                </a>
            </div>

            <!-- meio -->
            <div class="middle">

                <form class="create-post">
                    <div class="profile-photo">
                        <?php echo "<img src= '../$foto'>"; ?>
                    </div>
                    <input type="text" placeholder="O que você está pensando, <?php echo "$nome?"; ?>" id="create-post">
                    <input type="submit" value="Post" class="btn btn-primary btn-post">
                </form>

                <?php while ($post = $postagens->fetch(PDO::FETCH_ASSOC)) : ?>
                    <?php
                    $usuarioPostagem = $usuario->lerPorId($post['idUsuario']);        
                    ?>
                    <!-- publicações -->
                    <div class="feeds">
                        <!-- publicação -->
                        <div class="feed">
                            <div class="head">
                                <div class="user">
                                    <div class="profile-photo">
                                        
                                    <?php echo "<img src='../{$usuarioPostagem['foto']}' />"; ?>
                                    </div>
                                    <div class="ingo">
                                        <h3><?php echo $usuarioPostagem['nome']; ?></h3>
                                        <small><?php echo $post['titulo']; ?></small>
                                    </div>
                                </div>
                                <span class="edit">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </span>
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
                                <span><img src="../img/perfil.jpg"></span>
                                <span><img src="../img/kauaV.jpg"></span>
                                <span><img src="../img/arthur.jpg"></span>
                                <p>Curtido por <b>Dalmo Xiru</b> e <b>1,564 outros</b></p>
                            </div>

                            <div class="caption">
                                <p><b><?php echo $usuarioPostagem['nome']; ?></b><?php echo $post['descricao']; ?>
                                </p>
                            </div>

                            <div class="comments text-muted">Ver todos os comentários</div>

                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
</body>

</html>