<?php
session_start();
include_once 'Config/config.php'; // Ajuste o caminho conforme necessário
include_once 'Classes/Usuario.php'; // Ajuste o caminho conforme necessário

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Inicializa a classe Usuario com a conexão $db
$usuario = new Usuario($db);

// Verifica se foi enviado o ID do usuário a ser deletado
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Chama o método deletarUsuario da classe Usuario
    if ($usuario->deletarUsuario($id)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar usuário.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID do usuário não fornecido.']);
}
?>
