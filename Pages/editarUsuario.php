<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';


$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$usuario_adm = $dados_usuario['adm'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $foto = "";
    $telefone = $_POST['telefone'];
    $nascimento = date($_POST['nascimento']);
    $sexo = $_POST['sexo'];
    $adm = isset($_POST['adm']) ? 1 : 0; // 1 = verdadeiro, 0 = falso
    $ativo = isset($_POST['ativo']) ? 1 : 0; // 1 = verdadeiro, 0 = falso

    $usuario->atualizar($id, $nome, $email, $telefone, $sexo, $senha, $foto, $nascimento, $adm, $ativo);
    header('Location: portal.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>