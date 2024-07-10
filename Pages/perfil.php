<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfil.css">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Responsivo Web Site</title>
</head>
    
<body style= "background-image: url('/img/fundo-pet.jpg');">
    <nav>
        <div class="container">
        <a href="index.php"><h2 class="log">
                Rede Social
            </h2></a>
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Pesquisar">
            </div>
            <div class="create">
                <a href=""><input class="btn btn-primary" value="Criar"></a>
                <a href="contato.php"><input class="btn btn-primary" value="Contato"></a>
                <a href="editarUsuario.phpid=<?php echo $row['id']; ?>"><input class="btn btn-primary" value="Editar perfil"></a>
                <div class="profile-photo">
                    <img src="../img/perfil.jpg" alt="">
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
                        <img src="../img/perfil.jpg" alt="">
                    </div>
                    <div class="handle">
                        <h4>Mauricio Scheffer</h4>
                        <p class="text-muted">
                            @maumau
                        </p>
                        <div class="input-single">
                        <textarea class="input" name="" type="text"></textarea>
                        <label for="nome">Meus Pets🐶</label>
                        </div>
                        <input type="submit" value="Salvar" class="btn btn-primary">
                    </div>
                </a>
            </div>

                 <!-- meio -->
                 <div class="middle">

                    <form class="create-post">
                        <div class="profile-photo">
                            <img src="../img/perfil.jpg" alt="">
                        </div>
                        <input type="text" placeholder="O que você está pensando, Mauricio?" id="create-post">
                        <input type="submit" value="Post" class="btn btn-primary">
                    </form>

                    <!-- publicações -->
                    <div class="feeds">
                        <!-- publicação -->
                        <div class="feed">
                            <div class="head">
                                <div class="user">
                                    <div class="profile-photo">
                                        <img src="../img/jeferson.jpg" alt="">
                                    </div>
                                    <div class="ingo">
                                        <h3>Xiru Master</h3>
                                        <small>Cachoerinha, 10 minutos atrás</small>
                                    </div>
                                </div>
                                <span class="edit">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </span>
                            </div>

                            <div class="photo">
                                <img src="../img/pinguim.jpg" alt="">
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
                                <p><b>Xiru Master</b>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    <span class="harsh-tag">#lifestyle</span>
                                </p>
                            </div>

                            <div class="comments text-muted">Ver todos os comentários</div>

                        </div>

                        <div class="feed">
                            <div class="head">
                                <div class="user">
                                    <div class="profile-photo">
                                        <img src="../img/kauaV.jpg">
                                    </div>
                                    <div class="ingo">
                                        <h3>Kaua Valim</h3>
                                        <small>Sapucaia do Sul, 2 dias atrás</small>
                                    </div>
                                </div>
                                <span class="edit">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </span>
                            </div>

                            <div class="photo">
                                <img src="../img/gato.jpg">
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
                                <span><img src="../img/jeferson.jpg"></span>
                                <span><img src="../img/leo.jpg"></span>
                                <span><img src="../img/perfil.jpg"></span>
                                <p>Curtido por <b>Xiru Master</b> e <b>1,120 outros</b></p>
                            </div>

                            <div class="caption">
                                <p><b>Xiru Master</b>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    <span class="harsh-tag">#lifestyle</span>
                                </p>
                            </div>

                            <div class="comments text-muted">Ver todos os comentários</div>
                            <!-- fim da publicação -->
                            <!-- fim do meio do site -->
                        </div>
                    </div>
                    </div>
        </div>
    </main>
</body>
</html>

