<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit();
}

include_once 'config/config.php';
include_once 'classes/Curtida.php';

$curtida = new Curtida($db);

if (isset($_POST['id']) && isset($_POST['acaoCurtida'])) {
    $postId = $_POST['id'];
    $acaoCurtida = $_POST['acaoCurtida'];
    $usuarioId = $_SESSION['usuario_id'];

    $jaCurtiu = $curtida->jaCurtiu($postId, $usuarioId);

    if ($acaoCurtida == 'curtir' && !$jaCurtiu) {
        $curtida->curtir($postId, $usuarioId);
    } elseif ($acaoCurtida == 'descurtir' && $jaCurtiu) {
        $curtida->descurtir($postId, $usuarioId);
    }

    $totalCurtidas = $curtida->contarCurtidas($postId);

    echo json_encode(['success' => true, 'likes' => $totalCurtidas]);
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos']);
}
?>
