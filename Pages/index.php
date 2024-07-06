<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Responsivo Web Site</title>
</head>

<body>
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
                <a href="cadastro.php"><label class="btn btn-primary">Cadastrar</label></a>
                <a href="login.php"> <label class="btn btn-primary">Logar</label></a>
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
                    <a class="menu-item" id="notifications">
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
                    </a>

                    <a href="" class="menu-item" id="messages-notifications">
                        <span><i class="fa-solid fa-message"><small class="notification-count">6</small></i></span>
                        <h3>Mensagens</h3>
                    </a>

                    <a href="" class="menu-item">
                        <span><i class="fa-solid fa-bookmark"></i></span>
                        <h3>Atividades</h3>
                    </a>

                    <a href="" class="menu-item">
                        <span><i class="fa-solid fa-chart-simple"></i></span>
                        <h3>Analises</h3>
                    </a>

                    <a href="" class="menu-item">
                        <span><i class="fa-solid fa-circle-half-stroke"></i></span>
                        <h3>Teme</h3>
                    </a>

                    <a href="" class="menu-item">
                        <span><i class="fa-solid fa-gear"></i></span>
                        <h3>Configurações</h3>
                    </a>

                </div>
                <!-- cabou a sidebar -->
                <label for="create-post" class="btn btn-primary">Criar publicação</label>
            </div>
            <!-- fim da esquerda -->

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

            <!-- direito -->
                 <div class="right">
                <div class="messages">
                    <div class="heading">
                        <h4>Mensagens<h4><i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    Pesquisar
                     <div class="search-bar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" placeholder="Procure mensagens" id="message-search">
                     </div>
                      <div class="category">
                        <h6 class="active">Primeiro</h6>
                        <h6>Geral</h6>
                        <h6 class="message-requests">Solicitações(8)</h6>
                      </div>
                       Mensagem 
                       <div class="message">
                        <div class="profile-photo">
                            <img src="../img/jeferson.jpg" alt="">
                        </div>
                        <div class="message-body">
                            <h5>Jeferson Leon</h5>
                            <p class="text-muted">Projeto pra entregar hein xiruzão</p>
                        </div>
                       </div>
                       <div class="message">
                            <div class="profile-photo">
                                <img src="../img/jeferson.jpg" alt="">
                            </div>
                        <div class="message-body">
                            <h5>Jeferson Leon</h5>
                            <p class="text-bold">3 mensagens</p>
                            </div>  
                    </div>
                </div>
                <!-- fim das mensagens -->

                 <!-- solicitações de amigos  -->
                 <div class="friend-requests">
                    <h4>Solicitações</h4>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="../img/vitor.jpg" alt="">
                            </div>
                            <div>
                                <h5>Vitinho</h5>
                                <p class="text-muted">
                                    4 amigos em comum
                                </p>
                                <div class="action">
                                    <button class="btn btn-primary">
                                        Aceitar
                                    </button>
                                    <button class="btn">
                                        Recusar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div> 
        </div>
    </main>
</body>

</html>