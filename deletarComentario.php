<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'Config/config.php';
include_once 'Classes/Comentario.php';


$comentario = new Comentario($db);
if (isset($_GET['comentario'])) {
    $id = $_GET['comentario'];
    $comentario->deletar($id);

    // Verifica se a URL de referência existe
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        // Se não houver uma página de referência, redireciona para o index
        header('Location: index.php');
    }
    
    exit();
}
?>
