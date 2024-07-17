<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'Config/config.php';
include_once 'Classes/Post.php';


$postagem = new Post($db);
if (isset($_GET['postagem'])) {
    $id = $_GET['postagem'];
    $postagem->deletarPostagem($id);
    header('Location: index.php');
    exit();
}
?>
