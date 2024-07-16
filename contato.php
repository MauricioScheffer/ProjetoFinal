<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'Config/config.php';
include_once 'Classes/Usuario.php';

//Obtendo dados do usuário logado
$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$idUsuario = $dados_usuario['id'];
$foto = $dados_usuario['foto'];
$admin = $dados_usuario['adm'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/contato.css">
    <script src="https://kit.fontawesome.com/fff353ec8e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Contato</title>
</head>
<body>
<nav>
        <div class="container">
            <a href="index.php"><h2 class="log">
                <img src="img/LogoBlack.png">
            </h2></a>
            
            <div class="create">
                <a href="index.php"><label class="btn btn-primary">Voltar</label></a>
                <div class="profile-photo">
                <?php echo "<img id='profile-img' src= '$foto'>"; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->
    <main>
        <div class="container">
            <div class="esquerda">
                <h2>Contate-nos</h2>
                <div class="icons">
                    <a href=""><span><i class="fa-brands fa-instagram"></i></span></a>
                    <a href="https://github.com/MauricioScheffer/ProjetoFinal.git"><span><i class="fa-brands fa-github"></i></span></a>
                    <a href="https://chat.whatsapp.com/H7ngbwslCQp8jozQvA9KLS"><span><i class="fa-brands fa-whatsapp"></i></span></a>
                </div>
                <div class="sobre">
                    <h3><i class="fa-regular fa-envelope"></i>Email</h3>
                    <p>saolucas@gmail.com</p><br>
                    <h3><i class="fa-solid fa-phone-volume"></i>Comunidade</h3>
                    <p>Whatsapp Link</p><br>
                    <h3><i class="fa-brands fa-facebook"></i></i>Facebook</h3>
                    <p>PetHub Social</p><br>
                    <h3><i class="fa-regular fa-map"></i>Endereço</h3>
                    <p>Rua 25 de Julho, 564 <br>Vargas, Sapucaia Do Sul</p>
                </div>
            </div>

            <div class="container-mapa">
            <iframe class="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3461.6086236212245!2d-51.13877083677579!3d-29.817849329746227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95196f2a593c6151%3A0xee0be7c4a3eba933!2sCol%C3%A9gio%20ULBRA%20S%C3%A3o%20Lucas!5e0!3m2!1spt-BR!2sbr!4v1720484142527!5m2!1spt-BR!2sbr"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
<script src="./Script/main.js"></script>
</html>